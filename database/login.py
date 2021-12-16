import hashlib, binascii, os

def check_password(stored_password, user_password):
    salt = stored_password[:64]
    stored_password = stored_password[64:]
    pass_hash = hashlib.pbkdf2_hmac('sha512',user_password.encode('utf-8'),salt.encode('ascii'),100000)
    pass_hash = binascii.hexlify(pass_hash).decode('ascii')
    return pass_hash == stored_password

if __name__ == '__main__':
    import sys
    check_password(sys.argv[1], sys.argv[2])
