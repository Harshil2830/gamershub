import smptlib
from email.message import EmailMessage

def email_alert(subject, body, to):
    msg = EmailMessage()
    msg.set_content(body)
    msg['subject'] = subject
    msg['to'] = to

    user = "colorslash@gmail.com"
    password = "@Pples33!"

    server = smtplib.SMTP("smtp.gmail.com",587)
    server.starttls()
    server.login(user,password)

    server.quit()

if __name__ == '__main__':
    email_alert("hey","Hello","colorslash@gmail.com")
content = 'example'

mail = smtplib.SMTP('smtp.gmail.com',587)

mail.ehlo()

mail.starttls()

mail.login('colorslash@gmail.com','@Pples33!')

mail.sendmail('colorslash@gmail.com','colorslash@gmail.com',content)

mail.close()