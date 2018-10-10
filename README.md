# Mit XAMPP: HOSTS und VHOSTS Datei automatisch anhand der HTDOCS Verzeichnisse generieren lassen

Mich hats mittlerweile genervt, immer das gleiche tun zu müssen - mit dem Script anbei kann man einiges vereinfachen:

Das kleine Script durchsucht den HTDOCS Ordner und erstellt anhand dieser Informationen automatisch die Windows HOSTS Datei sowie die Apache VHOSTS. Der Name des Ordner wird als Hostname genommen. Man muss also nicht immer den gleichen Kram manuell machen.

Alternativ kann man jeweils in den Ordnern eine Datei "htdocs.ini" anlegen und dann werden diese Daten als Domain/Alias verwendet.

Also:

* xampp.php In den XAMPP Ordner kopieren
* Pfade im Script oben evtl. anpassen
* xampp_shell.bat als Administrator öffnen (rechte Maustaste, Als Administrator ausführen...)
* Wechseln mit "cd c:\xampp"
* Script ausführen mit "php xampp.php"

Wenn sich was an der Config geändert hat, eventuell noch Apache neu starten.

# Verzeichnisstruktur

- C:\xampp\htdocs
  - \website1
    - htdocs.ini
  - \websit2
    - htdocs.ini
  - ...
