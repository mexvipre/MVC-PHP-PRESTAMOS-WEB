# 📄 Proyecto: Sistema de Préstamos - Parte 1 (Web PHP-MVC)

Este repositorio contiene la **primera fase** del sistema de gestión de préstamos, desarrollada en **PHP** utilizando el patrón **MVC (Modelo-Vista-Controlador)**. Esta parte corresponde únicamente al **módulo web**.

---

## 🧩 Funcionalidades Implementadas

- Registro y listado de **beneficiarios**
- Registro y listado de **contratos**
- Validación para evitar contratos activos duplicados por beneficiario
- Conexión a base de datos MySQL
- Consultas SQL para control de cuotas, pagos y penalidades

---

## 🗃️ Estructura de carpetas

app/
├── controllers/
├── models/
├── views/      
config/
   └── conexion.php
index.php   

---

## 💾 Base de datos

La base de datos se llama `prestamos` y contiene las siguientes tablas:

- `beneficiarios`
- `contratos`
- `pagos`

Puedes encontrar el script SQL en:  
`config/database/bd.sql`

---

## 🚀 Cómo ejecutar

1. Clona el repositorio:
   ```bash
   git clone https://github.com/mexvipre/MVC-PHP-PRESTAMOS-WEB.git
