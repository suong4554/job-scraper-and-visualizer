import json
import re

import ssl
from urllib.request import Request, urlopen

from bs4 import BeautifulSoup as bs
BASE_URL = "https://www.indeed.com/"

#https://www.jobspikr.com/blog/scraping-indeed-job-data-using-python/

#ignore ssl certificate errors
ctx = ssl.create_default_context()
ctx.check_hostname = False
ctx.verify_mode = ssl.CERT_NONE

def main():
    name_of_city = "New York City"
    keywords = "datascience"
    number_of_pages = 10

    #Preprocess data
    name_of_city = name_of_city.replace(" ", "+")
    keywords = keywords.replace(" ", "+")
    number_of_pages = int(number_of_pages)

    url_to_scrape = BASE_URL + "/jobs?q=" + keywords + "&l=" + name_of_city

    data_collected = scrape_data(url_to_scrape, number_of_pages)

    with open('data.json', "w") as file:
        json.dump(data_collected, file, sort_keys=True, indent = 4, ensure_ascii=False)

def scrape_data(url, number_of_pages):
    data_collected = []
    for i in range(number_of_pages):
        extension = ""
        if i is not 0:
            extension = "&start=" + str(i*10)
            url_added = url + extension
            print(url_added)
            req = Request(url_added, headers= {'User-Agent': 'Mozilla/5.0'})

            web_page = urlopen(req).read()
            data_raw = bs(web_page, 'html.parser')
            data_collected = get_data_html(data_collected, data_raw)

    return data_collected


def get_data_html(data_collected, data_raw):
    job_posts = []
    for div in data_raw.findAll('div', attrs={'class':'jobsearch-SerpJobCard unifiedRow row result'}):
        job = dict()
        job = extract_data_points(job, div)
        job_posts.append(div['data-jk'])
        single_job_post_extension_url = "https://www.indeed.com/viewjob?jk=" + div['data-jk']
        job['url'] = single_job_post_extension_url
        req = Request(single_job_post_extension_url, headers= {'User-Agent': 'Mozilla/5.0'})
        web_page = urlopen(req).read()
        job_raw = bs(web_page, 'html.parser')

        for inside_div in job_raw.findAll('div', attrs={"class": "jobsearch-jobsearch-jobDescriptionText"}):
            details = inside_div.text.strip()[:100] + "..."
            job["details"] = details.replace(" +", "")
        data_collected.append(job)
    return data_collected


def extract_data_points(job, div):
    for a in div.findAll('a', attrs={"class": "jobtitle turnstileLink"}):
        job['title'] = a['title']
    for a1 in div.findAll('a', attrs={"data-tn-element": "companyName"}):
        job['companyName'] = a1.text.strip()
    for span in div.findAll('span', attrs={"class": "ratingsContent"}):
        job['rating'] = span.text.strip()
    for span1 in div.findAll('span', attrs={"class": "location accessible-contrast-color-location"}):
        job['location'] = span1.text.strip()
    for div1 in div.findAll('div', attrs={"class": "summary"}):
        summary = div1.text.strip()
        job['summary'] = summary.replace(' +', "")
    for span2 in div.findAll('span', attrs={'class':'date'}):
        job['date'] = span2.text.strip()
    return job



if __name__ == "__main__":
    main()
    print("Done")
