import pymysql

def conectar_db():
    servidor = "localhost"
    usuario = "root"
    clave = ""
    db = "apes"

    conexion = pymysql.connect(host=servidor, user=usuario, password=clave, database=db)
    return conexion
