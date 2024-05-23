# FortilHR

## Specifications

### Purpose
The aim of this mobile application is to centralize and facilitate the organization and logistics of Fortil events.

### Features   
* Store various documents (forms, PDFs, QR codes, etc.)
* Send notifications when a document is filed
* Send reminders such as “You have not confirmed your attendance”, “You have one week left before your seminar, please fill in the questionnaire”, etc.
* Several registration modules: 
    - user account (for interns)
    - guest account (for externals)
    - editor account (for those authorized to make modifications)  
* Adapt to different phones (iOS, Android)  
* Log in with Fortil SSO  
* Compliance with cybersecurity standards 
 
### UI
The application must follow Fortil's graphic charter.


## Technical specifications

### Features
Document storage :
- On server, retrieved as needed from the app

Sending notifications:
- When a document is uploaded
- When an event is published
- Form-filling reminders:
    - Need to retrieve information from form fillers

Adapt to different phones:
- PWA to use web technologies, simpler to manage and cross platform

Connection :
- SSO Fortil

### Chosen technologies
- [Symfony 7](https://symfony.com/) for the back-end
- [Endroid QR Code](https://github.com/endroid/qr-code-bundle?tab=readme-ov-file) to generate QR codes. Solution to display QR code easily: https://stackoverflow.com/questions/44559897/endroid-qr-code-in-twig-in-symfony
- [Symfony Docker](https://github.com/dunglas/symfony-docker/tree/main) as environment, using [FrankenPHP](https://frankenphp.dev/), [Caddy](https://caddyserver.com/) and [Docker](https://www.docker.com/)

### Assets

#### Fonts
Use the Fortil font: [GT Eesti](https://befonts.com/gt-eesti-font-family.html)

## Project tools

### CS Fixer
Run with: ```vendor/bin/php-cs-fixer fix```