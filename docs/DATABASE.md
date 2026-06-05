# Documentación - SoftStats CJB

## 📊 Schema de Base de Datos

### Tablas Principales

#### 1. **users**
```sql
id INT PRIMARY KEY
name VARCHAR(255)
email VARCHAR(255) UNIQUE
password VARCHAR(255)
role ENUM('admin', 'anotador', 'jugador', 'publico')
email_verified_at TIMESTAMP NULL
created_at TIMESTAMP
updated_at TIMESTAMP
```

#### 2. **players**
```sql
id INT PRIMARY KEY
nombre VARCHAR(255)
apellido VARCHAR(255)
numero INT UNIQUE
posicion VARCHAR(100)
fecha_nacimiento DATE
telefono VARCHAR(20) NULL
correo VARCHAR(255) NULL
foto VARCHAR(255) NULL
estado ENUM('activo', 'inactivo')
user_id INT NULL (FK: users.id)
created_at TIMESTAMP
updated_at TIMESTAMP
deleted_at TIMESTAMP NULL (Soft Delete)
```

#### 3. **seasons**
```sql
id INT PRIMARY KEY
nombre VARCHAR(255)
fecha_inicio DATE
fecha_fin DATE
estado ENUM('activa', 'finalizada')
created_at TIMESTAMP
updated_at TIMESTAMP
```

#### 4. **teams** (Equipos Rivales)
```sql
id INT PRIMARY KEY
nombre VARCHAR(255)
manager VARCHAR(255)
telefono VARCHAR(20) NULL
logo VARCHAR(255) NULL
created_at TIMESTAMP
updated_at TIMESTAMP
```

#### 5. **matches** (Partidos)
```sql
id INT PRIMARY KEY
season_id INT (FK: seasons.id)
rival_team_id INT (FK: teams.id)
fecha DATE
hora TIME
lugar VARCHAR(255)
estado ENUM('programado', 'en_juego', 'finalizado')
resultado ENUM('ganado', 'perdido', 'empate') NULL
carreras_equipo INT NULL
carreras_rival INT NULL
created_at TIMESTAMP
updated_at TIMESTAMP
```

#### 6. **batting_stats** (Estadísticas de Bateo)
```sql
id INT PRIMARY KEY
player_id INT (FK: players.id)
match_id INT (FK: matches.id)
turnos_bate INT
hits INT
dobles INT
triples INT
jonrones INT
carreras INT
impulsadas INT
boletos INT
ponches INT
created_at TIMESTAMP
updated_at TIMESTAMP
```

#### 7. **pitching_stats** (Estadísticas de Picheo)
```sql
id INT PRIMARY KEY
player_id INT (FK: players.id)
match_id INT (FK: matches.id)
entradas_lanzadas DECIMAL(3,1)
hits_permitidos INT
carreras_limpias INT
boletos INT
ponches INT
victoria BOOLEAN
derrota BOOLEAN
salvamento BOOLEAN
created_at TIMESTAMP
updated_at TIMESTAMP
```

#### 8. **fielding_stats** (Estadísticas Defensivas)
```sql
id INT PRIMARY KEY
player_id INT (FK: players.id)
match_id INT (FK: matches.id)
asistencias INT
putouts INT
errores INT
dobles_matanzas INT
created_at TIMESTAMP
updated_at TIMESTAMP
```

## 🔗 Relaciones

```
users (1) ─── (N) players
seasons (1) ─── (N) matches
teams (1) ─── (N) matches
matches (1) ─── (N) batting_stats
matches (1) ─── (N) pitching_stats
matches (1) ─── (N) fielding_stats
players (1) ─── (N) batting_stats
players (1) ─── (N) pitching_stats
players (1) ─── (N) fielding_stats
```

## 📐 Índices Recomendados

```sql
-- players
CREATE INDEX idx_players_user_id ON players(user_id);
CREATE INDEX idx_players_estado ON players(estado);

-- matches
CREATE INDEX idx_matches_season_id ON matches(season_id);
CREATE INDEX idx_matches_rival_team_id ON matches(rival_team_id);
CREATE INDEX idx_matches_fecha ON matches(fecha);

-- batting_stats
CREATE INDEX idx_batting_player_match ON batting_stats(player_id, match_id);

-- pitching_stats
CREATE INDEX idx_pitching_player_match ON pitching_stats(player_id, match_id);

-- fielding_stats
CREATE INDEX idx_fielding_player_match ON fielding_stats(player_id, match_id);
```

## 🎯 Restricciones

- **Números de jugadores**: Únicos en la tabla
- **Emails**: Únicos en la tabla
- **Soft Deletes**: Players usa soft deletes
- **Cascade**: FK con ON DELETE CASCADE para mantener integridad

---

Última actualización: 2026-06-05
