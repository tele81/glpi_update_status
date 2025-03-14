# Automatische Statusaktualisierung von Tickets in GLPI

Dieses PHP-Skript automatisiert die Aktualisierung von Tickets in einem GLPI-System. Es überprüft alle Tickets mit dem Status "Neu" (Status = 1) und ändert ihren Status auf "In Bearbeitung" (Status = 2), wenn eine Anmerkung oder Änderung zu einem Ticket vorhanden ist.

## 📌 Funktionsweise

### 1️⃣ Laden der GLPI-Konstanten und Datenbankverbindung
- Das Skript lädt die GLPI-Umgebung mit `includes.php`, um auf die Datenbank und Funktionen zugreifen zu können.
- Es überprüft, ob die DB-Klasse existiert, um Fehler zu vermeiden.

### 2️⃣ Abrufen der Tickets mit dem Status "Neu"
- Das Skript ruft alle Tickets mit dem Status "Neu" (Status = 1) aus der Datenbank ab.

### 3️⃣ Überprüfen auf Änderungen oder Anmerkungen
- Für jedes Ticket wird überprüft, ob es in der Tabelle `glpi_itilfollowups` Anmerkungen oder Änderungen gibt.
- Wenn ja, wird der Status des Tickets von "Neu" auf "In Bearbeitung" (Status = 2) geändert.

### 4️⃣ Ablauf des Skripts
- Das Skript wird ausgeführt, um die Tickets zu überprüfen und deren Status zu ändern, falls eine Änderung vorliegt.
- Eine entsprechende Bestätigung oder Fehlermeldung wird für jedes Ticket ausgegeben.

## 🔧 Voraussetzungen

- Ein funktionierendes GLPI-System mit MySQL-Datenbank.
- Ein Webserver mit PHP-Unterstützung.

## 🚀 Installation

1. Kopiere das Skript in das GLPI-Verzeichnis oder an einen passenden Ort mit Zugriff auf die Datenbank.
2. Führe das Skript manuell aus, indem du es über die Kommandozeile oder den Webserver aufrufst.

## 🛠️ Nutzung

Das Skript kann über die Kommandozeile oder einen Webserver aufgerufen werden:

```bash
php update_ticket_status.php
