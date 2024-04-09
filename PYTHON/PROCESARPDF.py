import os
from PyPDF2 import PdfReader
from CONN import conectar_db

def extraer_texto_insertar_db(pdf_file):
    connection = conectar_db()

    if not os.path.isfile(pdf_file):
        print(f"Error: El archivo PDF '{pdf_file}' no existe.")
        return

    pdf_path = os.path.abspath(pdf_file)

    with open(pdf_path, 'rb') as file:
        reader = PdfReader(file)

        if reader.is_encrypted:
            print("Error: El archivo PDF está protegido y no se puede procesar.")
            return

        for page in reader.pages:
            text = page.extract_text()
            
            with connection.cursor() as cursor:
                sql = "INSERT INTO pdf (contenido) VALUES (%s)"
                cursor.execute(sql, (text,))
                connection.commit()

    connection.close()

pdf_file = 'PYTHON/prueba1.pdf'
extraer_texto_insertar_db(pdf_file)
