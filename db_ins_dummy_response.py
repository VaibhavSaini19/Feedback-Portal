import mysql.connector
import random
from mysql.connector import Error
try:
    conn = mysql.connector.connect(
    host="localhost",
    user="root",
    passwd="",
    database="feedback_portal"
    )


    mycursor = conn.cursor(buffered=True)
    """mycursor.execute("select count(token) from student_tokens where status status ='0' ")
    count_of_token = mycursor.rowcount()
    """
    #to store all the feedback id whose status is 0
    mycursor.execute("select token,dept,year,block from student_tokens where status = '0'")
    result_1 = mycursor.fetchall()
    feedback_tokens={}
    for row in result_1:
        feedback_tokens[row[0]] = [row[1],row[2],row[3]]

    #for count of questions
    mycursor.execute("select question,id,type from questions")
    questions_res = mycursor.fetchall()
    count_of_question = mycursor.rowcount
    question={}                   # to store the questions
    qid_type={}                   #to store question id and type
    i=1
    for row in questions_res:
        question[row[0]]=1
        qid_type[i]=[row[1],row[2]]
        i+=1
    #to fetch the number of options for a question
    for qn, opt_ctr in question.items():
        temp_count=0
        for j in range(1,6):    
            
            mycursor.execute("select option"+ str(j) +" from questions where question = '"+qn+"' AND option"+str(j)+" IS NOT NULL")
            if mycursor.rowcount == 0:
                break
            temp_count+=1
        question[qn] = [int(x) for x in range(1,temp_count+1)]    
        i+=1

    # to fetch data facult_name and course from load_distribution table
    for i in feedback_tokens.keys():
        mycursor.execute("select fac_abbr,course_abbr from load_distribution where dept='"+feedback_tokens[i][0]+"' AND year='"+feedback_tokens[i][1]+"' AND block='"+feedback_tokens[i][2]+"'")
        result_fac = mycursor.fetchall()
        # print(i, feedback_tokens[i])
        # print(len(result_fac))
        for row in result_fac:
            feedback_tokens[i].extend([row[0],row[1]])
        # print(i, feedback_tokens[i])

    #to record response in student table
    sql = "INSERT INTO response (faculty, course, dept, year, block, type, qid, score, token) VALUES (%s, %s,%s, %s,%s, %s,%s, %s,%s)"
            
    for i in feedback_tokens.keys():
        j=1
        val=[]
        for question_no in question.keys():
            for k in range(3, len(feedback_tokens[i]), 2):
                random_choice = random.choice(question[question_no])
                val.append((feedback_tokens[i][k],feedback_tokens[i][k+1],feedback_tokens[i][0],feedback_tokens[i][1],feedback_tokens[i][2],qid_type[j][1],qid_type[j][0],random_choice,i))
            
            j+=1
        mycursor.executemany(sql,val)
        sql_1="Update student_tokens SET status = 1 where token='"+i+"'"
        mycursor.execute(sql_1)
        conn.commit()
    
    print("Done")

except mysql.connector.Error as error:
    print ("The Error is ",error)
finally:
    if (conn.is_connected()):
        mycursor.close()
        conn.close()
        print("MySQL connection is closed")    
        


        

