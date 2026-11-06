import sys
import json
import os
import logging

from pyhanko.pdf_utils.reader import PdfFileReader
from pyhanko.sign.validation import validate_pdf_signature
from pyhanko_certvalidator import ValidationContext


# Log PyHanko tidak boleh mencampuri output JSON.
logging.disable(logging.CRITICAL)


def output(status, message, certificate=""):
    print(json.dumps({
        "status": status,
        "message": message,
        "certificate": certificate
    }, ensure_ascii=False))


def validate_document(pdf_path):
    if not os.path.isfile(pdf_path):
        output("review", "File PDF tidak ditemukan.")
        return

    try:
        with open(pdf_path, "rb") as pdf_file:
            reader = PdfFileReader(pdf_file)
            signatures = reader.embedded_signatures

            if not signatures:
                output(
                    "unsigned",
                    "Tidak ditemukan tanda tangan digital tertanam pada PDF."
                )
                return

            validation_context = ValidationContext(
                allow_fetching=True
            )

            results = []

            for signature in signatures:
                try:
                    status = validate_pdf_signature(
                        signature,
                        signer_validation_context=validation_context
                    )

                    intact = bool(status.intact)
                    valid = bool(status.valid)

                    cert_name = "Informasi sertifikat tidak tersedia."

                    try:
                        cert = status.signing_cert
                        cert_name = (
                            cert.subject.human_friendly or cert_name
                        )
                    except Exception:
                        pass

                    results.append({
                        "intact": intact,
                        "valid": valid,
                        "certificate": cert_name,
                        "trusted": bool(status.trusted),
                        "bottom_line": bool(status.bottom_line)
                    })

                except Exception as error:
                    results.append({
                        "intact": None,
                        "valid": None,
                        "certificate": str(error),
                        "trusted": False,
                        "bottom_line": False
                    })

            certificates = "; ".join(
                item["certificate"] for item in results
            )

            # Integritas tanda tangan terbukti rusak.
            if any(item["intact"] is False for item in results):
                output(
                    "invalid",
                    "Tanda tangan digital tidak valid atau integritas dokumen berubah.",
                    certificates
                )
                return

            # Ada tanda tangan yang belum berhasil diperiksa.
            if any(item["intact"] is None for item in results):
                output(
                    "review",
                    "Tanda tangan ditemukan, tetapi integritasnya belum dapat dipastikan.",
                    certificates
                )
                return

            # Seluruh tanda tangan lolos pemeriksaan integritas
            # dan validitas kriptografis.
            if all(
                item["intact"] is True and item["valid"] is True
                for item in results
            ):
                output(
                    "valid",
                    "Tanda tangan digital berhasil diverifikasi secara kriptografis. Pemeriksaan kepercayaan sertifikat CA dan TSA ditampilkan terpisah.",
                    certificates
                )
                return

            output(
                "invalid",
                "Pemeriksaan kriptografis tanda tangan tidak berhasil.",
                certificates
            )

    except Exception as error:
        output(
            "review",
            "PDF tidak dapat divalidasi: " + str(error)
        )


if __name__ == "__main__":
    if len(sys.argv) < 2:
        output("review", "Lokasi file PDF tidak diberikan.")
        sys.exit(1)

    validate_document(sys.argv[1])
