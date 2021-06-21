import pandas as pd
import os

dir_path = os.path.dirname(os.path.realpath(__file__))
df = pd.read_csv(dir_path + "/IMDb movies.csv")



import spacy 
import subprocess
from string import punctuation

nlp = spacy.load("en_core_web_sm")


def get_hotwords(nlp, text):
    result = []
    pos_tag = ['PROPN', 'ADJ', 'NOUN'] # 1
    doc = nlp(text.lower()) # 2
    for token in doc:
        # 3
        if(token.text in nlp.Defaults.stop_words or token.text in punctuation):
            continue
        # 4
        if(token.pos_ in pos_tag):
            result.append(token.text)

    return result # 5


df_spacy = df.copy()

df_spacy['key_words'] = df_spacy[""]
