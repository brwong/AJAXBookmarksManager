from BeautifulSoup import BeautifulSoup as bs
from random import randint

characs = 'abcdefghijklmnopqrstuvwxyz0123456789'
ids = []

def newid():
	global ids
	already = True
	while already:
		result = ''
		for i in range(7):
			result += characs[randint(0, len(characs)-1)]
		already = False
		for di in ids:
			if result==di:
				already = True
				break
	return result

bookmarkspage = "C:\\Documents and Settings\\Wong Family\\My Documents\\bookmarks-2008feb-new.html"
filer = open(bookmarkspage)
page = bs(filer.read())
filer.close()

anchors = page.findAll('a')

output = '<marks>\n\t<tags>\n\t\t<tag id="0">example</tag>\n\t\t<tag id="1">documentation</tag>\n\t\t<tag id="2">search</tag>\n\t</tags>\n\t<locations>\n'

for a in anchors:
	#try:del a['icon']
	#except:pass
	#try:del a['last_visit']
	#except:pass
	#try:del a['add_date']
	#except:pass
	#try:del a['last_charset']
	#except:pass
	#try:a['id']
	#except:pass#need id?
	#else:
	#	if a['id'][:4]=='rdf:':
	#		a['id'] = a['id'][4:]
	#try:pare = a.findParent('dt')
	#except:
	#	output += '<dt>'
	#	output += a.prettify()
	#	output += '</dt>'
	#else:
	#	output += pare.prettify()
	#	if pare.findNextSibling() and pare.findNextSibling().name=='dd':
	#		output += pare.findNextSibling().prettify()
	myid = ''
	try:a['id']
	except:
		myid = newid()
	else:
		if a['id'][:4]=='rdf:':
			myid = a['id'][4:]
		else:
			myid = a['id']
	output += '\t\t<loc id="'+myid+'">\n'
	ids.append(myid)
	if len(a.contents)==1:
		output += '\t\t\t<name>'+a.contents[0].encode('ascii','ignore')+'</name>\n'
	try:a['href']
	except:print myid+' no href!'
	else:output += '\t\t\t<ref>'+a['href'].replace('&','&amp;').replace('&amp;amp;','&amp;')+'</ref>\n'
	try:pare = a.findParent('dt')
	except:pass
	else:
		try:sib = pare.findNextSibling()
		except:pass
		else:
			if sib and sib.name=='dd' and len(sib.contents)==1:
				output += '\t\t\t<descr>'+sib.contents[0].encode('ascii','ignore').strip()+'</descr>\n'
	output += '\t\t</loc>\n'
output += '\t</locations>\n</marks>\n'
filer = open('locations.xml', 'w')
filer.write(output)
filer.close()
