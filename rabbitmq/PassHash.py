import hashlib, binascii, os

def hash_pass(passw):
    salt = hashlib.sha256(os.urandom(60)).hexdigest().encode('ascii')
    pass_hash = hashlib.pbkdf2_hmac('sha512',passw.encode('utf-8'),salt,100000)
    pass_hash = binascii.hexlify(pass_hash)
    return (salt+pass_hash).decode('ascii')

def check_password(stored_password, user_password):
    salt = stored_password[:64]
    stored_password = stored_password[64:]
    pass_hash = hashlib.pbkdf2_hmac('sha512',user_password.encode('utf-8'),salt.encode('ascii'),100000)
    pass_hash = binascii.hexlify(pass_hash).decode('ascii')
    return pass_hash == stored_password

stored_pass = hash_pass('MyPass')
print(stored_pass)
print(check_password(stored_pass , 'MyPass'))
print(check_password(stored_pass , 'WrongPass'))
