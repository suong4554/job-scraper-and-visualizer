import pandas as pd


extra_skills = [
    "statistics",
    "machine learning",
    "NLP",
    "natural language processing",
    "time series",
    "big data",
    "data visualization",
    "Scikit",
    "scipy",
    "plotly",
    "apache",
    "Tensorflow",
    "stats",
    "Statistics",
    "Mathematics",
    "computer science",
    "data engineering",
    "Numpy",
    "Pandas",
    "AWS",
    "Windows",
    "Linux",
    "Excel",
    "deep learning",
    "neural network",
    "Data Engineer",
    "knn",
    "supervised machine learning",
    "unsupervised machine learning",
    "Python",
    "SQL",
    "Sql",
    "Spark",
    "Hadoop",
    "Elasticsearch",
    "Full-Stack",
    "C++",
    "C#",
    "C/",
    "/C",
    " C ",
    "/R",
    "R/",
    "R,",
    " R ",
    "Ruby",
    "Matplotlib",
    "ML",
    "Java",
    "Javascript",
    "PHP",
    "Php",
    "Html",
    "CSS",
    "JScript",
    "Database",
    "blockchain",
    "Assembly",
    "Apex",
    "Git",
    "MS Office",
    "Microsoft office",
    "web dev"
    
    
]


def extract_key_word_count(df, extra_skills = extra_skills):
    exploded = []
    for index, row in df.iterrows():
        #row = row.to_frame()
        details = row.details
        for skill in extra_skills:
            skill = skill.lower()
            if skill in details.lower():
                row["skill"] = skill
                row_temp = row.to_frame().transpose()
                exploded.append(row_temp)    

    results = pd.concat(exploded)
    results.skill = results.skill.replace("r,", "R").replace(" r ", "R").replace("/r", "R").replace("r/", "R")
    results.skill = results.skill.replace("c,", "C").replace(" c ", "C").replace("/c", "C").replace("c/", "C")
    results = results.drop_duplicates()
    
    return results

