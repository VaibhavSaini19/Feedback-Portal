import random
import string
import mysql.connector

mydb = mysql.connector.connect(
    host="localhost",
    user="root",
    passwd="",
    db="feedback_portal"
)

# print(mydb.database)

sql = "INSERT INTO student_tokens (token, prn, dept, year, block, name, status) VALUES (%s, %s, %s, %s, %s, %s, %s)"
vals = []

for i in range(20):
    token = ''.join([random.choice(string.ascii_uppercase) for _ in range(6)])
    prn = ''.join([str(random.randint(1, 9)) for _ in range(10)])
    dept = random.choice(['SCET', 'SMCE', 'SHES'])
    year = random.choice(['SY', 'TY'])
    block = random.choice(['B1', 'B3', 'B5'])
    name = token[:3]
    status = 0
    # v = "('{}', '{}', '{}', '{}', '{}', '{}', {})".format(token, prn, dept, year, block, name, status)
    v = (token, prn, dept, year, block, name, status)
    vals.append(v)


# print(vals)
mycursor = mydb.cursor()
mycursor.executemany(sql, vals)
mydb.commit()

print(mycursor.rowcount, "record inserted.")

