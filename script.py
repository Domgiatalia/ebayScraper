# Import libraries
import requests
import urllib.request
import time
import csv
import json
import requests
import sys

from bs4 import BeautifulSoup

url = sys.argv[1]
testlist = []

for x in range(15):

    if x > 0:
        newurl = url + '&_pgn=' + str(x)
    else:
        newurl = url

    response = requests.get(newurl)
    soup = BeautifulSoup(response.text, "html.parser")

    for foo in soup.findAll('li', attrs={'class': 's-item'}):
        bar = foo.find('div', attrs={'class': 's-item__info'})
        href = bar.findAll('a', href=True)
        if href != []:
            testlist.append(href[0]['href'])

bigarr = []

for listing in testlist:
    response = requests.get(listing)
    soup = BeautifulSoup(response.text, "html.parser")

    for foo in soup.findAll('div', attrs={'class': 'sz940'}):
        CenterPanel = foo.find('div', {'id':'CenterPanelDF'})

        try:
            imagelink = CenterPanel.find('img', {'id':'icImg'})['src']
        except:
            imagelink = 'No Image'
        try:
            qty = CenterPanel.find('span', {'id':'qtySubTxt'}).text
        except:
            qty = 'No Qty'
        try:
            sold = CenterPanel.find('span', {'class':'soldwithfeedback'}).find('a').text
            sold = sold.replace(' sold', '')
        except:
            sold = 'No Sold'
        try:
            location = CenterPanel.find('span', {'itemprop':'availableAtOrFrom'}).text
        except:
            location = 'No Location'
        try:
            sellername = CenterPanel.find('span', {'class':'mbg-nw'}).text
        except:
            sellername = 'No Seller Name'
        try:
            sellerkarma = CenterPanel.find('span', {'class':'mbg-l'}).find('a').text
        except:
            sellerkarma = 'No Feedback'
        try:
            price = CenterPanel.find('span', {'id':'prcIsum'}).text
        except:
            price = 'No Price'
        try:
            condition = CenterPanel.find('div', {'id':'vi-itm-cond'}).text
        except:
            condition = 'No Condition'
        try:
            name = CenterPanel.find('h1', {'id':'itemTitle'}).contents[1]
        except:
            name = 'No Name'

        bigarr.append([listing,name,qty.strip(),sold,price,sellername,sellerkarma,condition,location,imagelink])

# with open('test.csv', 'w', newline='') as myfile:
#     wr = csv.writer(myfile, quoting=csv.QUOTE_ALL)
#     for log in bigarr:
#         wr.writerow(log)

print(json.dumps(bigarr))