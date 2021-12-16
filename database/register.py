import hashlib, binascii, os

def hash_pass(passw):
    salt = hashlib.sha256(os.urandom(60)).hexdigest().encode('ascii')
    pass_hash = hashlib.pbkdf2_hmac('sha512',passw.encode('utf-8'),salt,100000)
    pass_hash = binascii.hexlify(pass_hash)
    return (salt+pass_hash).decode('ascii')

if __name__ == '__main__':
    import sys
    hash_pass(sys.argv[1])
