# SoftStats CJB - Sistema de Gestión de Estadísticas Deportivas

Sistema completo para la gestión y análisis de estadísticas deportivas del Equipo de Softbol Ciudad Juan Bosch.

## 🏗️ Arquitectura Tecnológica

### Backend
- **Framework**: Laravel 12
- **PHP**: 8.3+
- **Base de Datos**: MySQL 8
- **Autenticación**: Laravel Sanctum + JWT
- **API**: RESTful con Swagger/OpenAPI

### Frontend
- **Framework**: Flutter 3.x
- **Diseño**: Material Design 3
- **Gestión Estado**: Provider/Riverpod
- **HTTP Client**: Dio

### Base de Datos
- **Motor**: MySQL 8
- **ORM**: Eloquent (Laravel)

## 📋 Módulos del Sistema

1. **Autenticación** - Login, logout, recuperación de contraseña
2. **Gestión de Jugadores** - CRUD completo con estadísticas
3. **Gestión de Equipos Rivales** - Administración de equipos
4. **Gestión de Temporadas** - Control de períodos de juego
5. **Gestión de Partidos** - Registro de encuentros
6. **Estadísticas de Bateo** - AVG, OBP, SLG, OPS
7. **Estadísticas de Picheo** - ERA, WHIP
8. **Estadísticas Defensivas** - Asistencias, putouts, errores
9. **Dashboard Deportivo** - Visualización de datos con gráficos
10. **Reportes** - PDF y Excel

## 👥 Roles del Sistema

- **Administrador**: CRUD completo, configuración, gestión de usuarios
- **Anotador**: Registrar estadísticas, consultar reportes
- **Jugador**: Consultar perfil y estadísticas
- **Público**: Consultar estadísticas públicas

## 🚀 Inicio Rápido

### Backend
```bash
cd backend
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan serve
```

### Frontend
```bash
cd mobile
flutter pub get
flutter run
```

## 📁 Estructura del Proyecto

```
softstats/
├── backend/          # Laravel 12 - API REST
├── mobile/           # Flutter 3.x - Aplicación móvil
├── docs/             # Documentación
└── README.md         # Este archivo
```

## 🔐 Credenciales Iniciales

- **Usuario**: admin@softstats.com
- **Contraseña**: Admin123*

## 📚 Documentación

- [Backend Setup](./backend/SETUP.md)
- [Mobile Setup](./mobile/SETUP.md)
- [API Documentation](./backend/SWAGGER.md)
- [Database Schema](./docs/DATABASE.md)

## 🛠️ Tecnologías

- Laravel 12
- PHP 8.3+
- MySQL 8
- Flutter 3.x
- Provider/Riverpod
- Dio
- JWT
- Sanctum

## 📝 Licencia

Proyecto privado - Ciudad Juan Bosch

## 👨‍💼 Arquitecto del Proyecto

Desarrollado como sistema empresarial con arquitectura limpia, SOLID principles y best practices.

---

**Estado**: En desarrollo 🔨
