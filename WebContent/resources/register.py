import ConfigParser
import MySQLdb
import json
import requests
import os
import sys
import time

dir_path = os.path.dirname(os.path.realpath(__file__))
parser = ConfigParser.SafeConfigParser()
parser.read(dir_path + "/../../../myConfig.ini")

url = "http://" + parser.get("eLab", "api_Ip").strip('"') + "/register/"

body = {
	"api_uname":parser.get("eLab", "api_User").strip('"'), 
	"api_pass":parser.get("eLab", "api_Pass").strip('"'),
	"username":sys.argv[1],
	"email":sys.argv[2],
	"preferred_pass":sys.argv[3],
	"external_id":sys.argv[4]
}

my_headers = {"Content-Type": 'application/json'}

json_body = json.dumps(body)

while True:
	r = requests.post(url, json_body, headers=my_headers)
	if (r.status_code == requests.codes.created):
		break
	elif (r.status_code == requests.codes.SERVICE_UNAVAILABLE):
		time.sleep(7200)
	else:
		time.sleep(120)

cnx = MySQLdb.connect(host=parser.get("eLab", "db_Ip").strip('"'), db='oci_eLab', user=parser.get("eLab", "username").strip('"'), passwd=parser.get("eLab", "password").strip('"'))
cursor = cnx.cursor()

query = ("UPDATE Registration SET complete = true WHERE userId = " + sys.argv[4])

cursor.execute(query)
cnx.commit()
cursor.close()
cnx.close()
exit()