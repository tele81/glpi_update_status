<?php
// GLPI Konfiguration und Includes laden
define('GLPI_ROOT', __DIR__);
include(GLPI_ROOT . "/inc/includes.php");

// Überprüfen, ob die DB-Klasse existiert
if (!class_exists('DB')) {
    die('Datenbank-Klasse nicht gefunden. Überprüfe den Include-Pfad.');
}

// Erstelle eine Instanz von DB
$db = new DB();

// SQL-Abfrage zur Auswahl von Tickets mit Status 1 (Neu)
$sql = "SELECT t.id AS Ticket_ID, t.status AS Ticket_Status
        FROM glpi_tickets t
        WHERE t.status = 1"; // Nur Tickets mit Status 1 (Neu)

// Führe die SQL-Abfrage aus
$result = $db->query($sql);
if (!$result) {
    die('Datenbankfehler: ' . $db->error());
}

// Statusänderung durchführen
while ($row = $db->fetchArray($result)) {
    $ticketId = $row['Ticket_ID'];
    $ticketStatus = $row['Ticket_Status'];

    // Prüfen, ob das Ticket eine Anmerkung oder Änderung hat
    $checkUpdateSql = "SELECT COUNT(*) AS updates
                       FROM glpi_itilfollowups
                       WHERE items_id = $ticketId"; // Überprüft, ob es Einträge in der Followup-Tabelle gibt
    
    $updateResult = $db->query($checkUpdateSql);
    if (!$updateResult) {
        echo "Fehler bei der Überprüfung des Tickets #$ticketId.\n";
        continue;
    }

    $updateRow = $db->fetchArray($updateResult);
    if ($updateRow['updates'] > 0) {
        // Wenn es Anmerkungen oder Änderungen gab und der Status des Tickets noch "Neu" ist, setze den Status auf 2 (In Bearbeitung)
        if ($ticketStatus == 1) {
            $updateSql = "UPDATE glpi_tickets 
                          SET status = 2 
                          WHERE id = $ticketId";

            // Status aktualisieren
            if ($db->query($updateSql)) {
                echo "Ticket #$ticketId wurde auf Status 2 (In Bearbeitung) geändert.\n";
            } else {
                echo "Fehler bei der Aktualisierung des Tickets #$ticketId.\n";
            }
        } else {
            echo "Ticket #$ticketId hat den Status $ticketStatus, kein Statuswechsel erforderlich.\n";
        }
    } else {
        echo "Ticket #$ticketId wurde nicht aktualisiert. Kein Statuswechsel.\n";
    }
}
?>
