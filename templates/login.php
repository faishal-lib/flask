from flask import Flask, render_template, request
from telethon.sync import TelegramClient

# konfigurasi API & credentials dari App Telegram Anda
api_id = YOUR_API_ID 
api_hash = 'YOUR_API_HASH'

app = Flask(__name__)

@app.route('/')
def index():
    return render_template('index.html')

@app.route('/login', methods=['POST'])
def login():
    # input nomor telepon dari user
    phone_number = request.form['phone']
    
    # membuat TelegramClient instance 
    client = TelegramClient(phone_number, api_id, api_hash)
    client.connect()
    
    # meminta kode verifikasi
    if not client.is_user_authorized():
        client.send_code_request(phone_number)
        return render_template('login.html')
    
    # jika sudah authorized, mengirimkan pesan ke @CryptoTech_Research
    else:
        with client:
            channel = client.get_entity('CryptoTech_Research')
            client.send_message(channel, 'Ini adalah pesan dari aplikasi Python saya!')
        return 'Pesan berhasil dikirim!'
        
if __name__ == '__main__':
    app.run(debug=True)
