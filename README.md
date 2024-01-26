# webengy-clockin

## Webengineering-Class Project

Ziel dieses Projektes ist, ein funktionierendes Ein-und Ausstempelsystem für eine Zeiterfassung zu erstellen.

---

## Grobe Aufgabenplanung

1. Aufsetzen eines Webservers
  
2. Grundgerüst der Website entwerfen
  
3. Logik der Website entwickeln
  
4. Design der Website
  
5. Projekthandbuch erstellen
  

---

## 1. Aufsetzen eines Webservers

Es wurde innerhalb der Oracle Cloud eine Ubuntu-VM in einem virtuellen Netzwerk aufgesetzt welche als Host für den Apache2 Webserver und die MariaDB-SQL Datenbank dienen soll.

Alle Services (Apache2, MariaDB,...) werden momentan via Docker Container bereitgestellt.

Aktuell bestehen folgende Probleme.:

- [x] Apache2 ist erreichbar aber nicht berechtigt zum Anzeigen von Seiten
  
- [X] Die MariaDB ist momentan noch nicht erreichbar.
  

Der Server selbst ist über https://clockin.webengy.de erreichbar.

Aus Sicherheitsgründen müssen freie Ports angefragt werden.

---
