import requests

api_key = '912833e48751f24fee3f92de274ff5cb'
url = 'https://indosmm.id/api/v2'

data = {
    'key': api_key,
    'action': 'services'
}

response = requests.post(url, data=data)

print("Status Code:", response.status_code)
print("Raw Response Text:", response.text)

try:
    json_response = response.json()
    print("JSON Response:", json_response)
except ValueError:
    print("Gagal parsing JSON.")
