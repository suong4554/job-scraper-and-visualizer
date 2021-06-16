import pandas as pd
import requests
from bs4 import BeautifulSoup
import pickle

#html = requests.get("httP://www.nationmaster.com/country-info/stats/Media/Internet-users")


headers = {'User-Agent' : 'Mozilla/5.0 (Windows NT …o/20100101 Firefox/68.0'}

page = 1 
size = 15
totalList = []
temp = [] 
names = ""
iteration = 1

while(names != temp): 
#while(iteration < 100):
    print(page) 
    temp = names
    #html = requests.get("https://www.cargurus.com/Cars/inventorylisting/viewDetailsFilterViewInventoryListing.action?sourceContext=untrackedExternal_false_0&newSearchFromOverviewPage=true&inventorySearchWidgetType=AUTO&entitySelectingHelper.selectedEntity=d596&entitySelectingHelper.selectedEntity2=&zip=07840&distance=50000&searchChanged=true&modelChanged=false&filtersModified=true#resultsPage=" + str(page), headers=headers)
    html = requests.get("https://www.cargurus.com/Cars/inventorylisting/viewDetailsFilterViewInventoryListing.action?zip=07840&showNegotiable=true&sourceContext=untrackedExternal_false_0&distance=50000&entitySelectingHelper.selectedEntity=d596")
    iteration +=1
    if iteration%2 == 0:
        page +=1
    
    soup = BeautifulSoup(html.content, 'lxml')
    listings = soup.find_all("div", class_="cg-dealFinder-result-wrap clearfix")
    names = [data.find("span", itemprop="description") for data in listings] 
    size = len(totalList)
    for data in names:
        if str(data) not in totalList:
            totalList.append(str(data))
    size = len(totalList)
    print(size)


	



totalCars = []

for data in totalList:
    #print(data)
    if data is not None:
        dictTemp = {}
        #print(data)
        data = data.split("Used")#.split("for sale").split(", ").split(" miles")
        data = data[1].split("for sale")

        #Gets Model
        model = data[0]
        #print("model: " + model)
        dictTemp["model"] = model

        #Gets Price
        data = data[1].split(", ")
        price = data[0][2:]
        #print("price: " + price)
        dictTemp["price"] = price

        #Gets Mileage
        data = data[1].split(" miles")
        mileage = data[0]
        #print("mileage: " + mileage)
        dictTemp["mileage"] = mileage

        totalCars.append(dictTemp)

        
print(len(totalCars))



#print(names)
#print(listings)
#df = pd.read_html(str(table))
#print(df[0].to_json(orient='records'))
