# Layout King fuer Ilch 2.0

`King` ist ein dunkles Gaming-Layout fuer Ilch 2.0 mit flexibel steuerbaren Bereichen fuer Header, Navigation, Slider, Sidebar und Footer.

## Funktionen

- Header mit mittigem Logo und zwei frei konfigurierbaren Bannern
- Hauptnavigation auf Basis des Ilch-Menues
- fester Home-Button im Menue
- optionaler Startseiten-Slider mit 3 Slides
- rechte Sidebar ueber Ilch-Menue 2 und Boxen
- Breadcrumb ausserhalb der Startseite
- Footer mit wichtigen Links und frei definierbarem Copyright
- Mobile-Menue und schwebender Back-to-Top-Button
- umfangreiche AdvSettings direkt im Layout

## Installation

1. Den Ordner `application/layouts/king` in die eigene Ilch-Installation kopieren.
2. Im Ilch-Backend unter `Designs / Layouts` das Layout `King` aktivieren.
3. Unter den erweiterten Layout-Einstellungen Logo, Ambientfarbe, Breite, Banner, Slider, Social-Links und Footer-Inhalte pflegen.

## Aufbau

- `application/layouts/king/index.php`
  Standardlayout mit Header, Navigation, Slider, Content, Sidebar und Footer
- `application/layouts/king/index_full.php`
  identisch zu `index.php`, aber ohne Sidebar
- `application/layouts/king/style.css`
  komplettes Layout-Styling
- `application/layouts/king/config/config.php`
  Layout-Metadaten und alle Backend-Einstellungen
- `application/layouts/king/translations/`
  deutsche und englische Uebersetzungen fuer die Layout-Konfiguration

## Hinweise

- `index_full` nutzt exakt dasselbe Layout wie `index`, nur ohne Sidebar.
- Social-Icons werden nur angezeigt, wenn im Backend ein Link gepflegt ist.
- Die Content-Breite wird ueber die AdvSettings als `max-width` gesteuert.
- Das Layout ist fuer eine spaetere Weiterentwicklung bewusst modular vorbereitet.

## Version

Aktuelle Version: `1.0.0`

## Autor

- c0r1an
