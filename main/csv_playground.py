import csv
 
with open('tags.csv', 'r') as csv_file:
    csv_reader = csv.reader(csv_file)
    print(csv_reader)
    for line in csv_reader:
        print(line[0])




# existing_moods = "tags.csv"
# csvfile = open(existing_moods, "a")
# reader = csv.DictReader(csvfile)
# result = [dict(row.items()) for row in reader]
# print(result)



# try:
#     #
#     # Création de l'''écrivain'' CSV.

#     writer = csv.writer(file)
#     writer.writerow(['fast'])
# finally:

#      file.close()


# # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # MANUAL

# # Ouverture du fichier source.
# #
# # D'après la documentation, le mode ''b'' est
# # *obligatoire* sur les plate-formes où il est
# # significatif. Dans la pratique, il est conseillé
# # de toujours le mettre.
# # L'ouverture est en écriture, d'où le ''w''.
# #
# fname = "out.csv"
# file = open(fname, "wb")
 
# try:
#     #
#     # Création de l'''écrivain'' CSV.
#     #
#     writer = csv.writer(file)
 
#     #
#     # Écriture de la ligne d'en-tête avec le titre
#     # des colonnes.
#     writer.writerow( ('Prix', 'Désignation') )
 
#     #
#     # Écriture des quelques données.
#     writer.writerow( (9.80, 'Tarte aux pommes') )
#     writer.writerow( ('13.40', 'Galette des rois') )
#     writer.writerow( (2.45, 'Beignet') )
# finally:
#     #
#     # Fermeture du fichier source
#     #
#     file.close()




# import csv
# with open('eggs.csv', newline='') as csvfile:
#     spamreader = csv.reader(csvfile, delimiter=' ', quotechar='|')
#     for row in spamreader:
#         print(', '.join(row))

# import csv
# with open('eggs.csv', 'w', newline='') as csvfile:
#     spamwriter = csv.writer(csvfile, delimiter=' ',
#                             quotechar='|', quoting=csv.QUOTE_MINIMAL)
#     spamwriter.writerow(['Spam'] * 5 + ['Baked Beans'])
#     spamwriter.writerow(['Spam', 'Lovely Spam', 'Wonderful Spam'])


# >>> import csv
# >>> with open('names.csv', newline='') as csvfile:
# ...     reader = csv.DictReader(csvfile)
# ...     for row in reader:
# ...         print(row['first_name'], row['last_name'])
# ...
# Eric Idle
# John Cleese
#
# >>> print(row)
# OrderedDict([('first_name', 'John'), ('last_name', 'Cleese')])


# class ExcelFr(csv.excel):
#     # Séparateur de champ
#     delimiter = ";"