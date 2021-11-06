import smptlib

content = 'example';

mail = smtplib.SMTP('smtp.gmail.com',587);

mail.ehlo();

mail.starttls();

mail.login('colorslash@gmail.com','@Pples33!');

mail.sendmail('fromemail','',content);

mail.close()