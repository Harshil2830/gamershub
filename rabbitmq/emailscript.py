import smtplib
from email.message import EmailMessage

def email_alert(subject, body, to):
    msg = EmailMessage()
    msg.set_content(body)
    msg['subject'] = subject
    msg['to'] = to

    user = "gamershubtest@gmail.com"
    msg['from'] = user
    password = "rzxdnjillyjvcuar"

    server = smtplib.SMTP("smtp.gmail.com",587)
    server.starttls()
    server.login(user,password)
    server.send_message(msg)
    server.quit()

#if __name__ == '__main__':
#   email_alert("Gamers Hub Notification","Welcome to gamers hub!","akhan1337@hotmail.com")
#content = 'example'

def email_signup(username, email):
    msg = EmailMessage()
    body = "Welcome "+username+","+"\n\nYour account was succesfully created!"
    msg.set_content(body)
    msg['subject'] = "Welcome to the Game Cave!"
    msg['to'] = email

    user = "gamershubtest@gmail.com"
    msg['from'] = user
    password = "rzxdnjillyjvcuar"

    server = smtplib.SMTP("smtp.gmail.com",587)
    server.starttls()
    server.login(user,password)
    server.send_message(msg)
    server.quit()
    return "Success!"
if __name__ == '__main__':
    import sys
    email_signup(sys.argv[1], sys.argv[2])
