const express = require('express');
const { Pool } = require('pg');
const app = express();
const port = 3000;

// Middleware para parsear JSON antes de las rutas
app.use(express.json());

// Configuración de conexión a PostgreSQL
const pool = new Pool({
  host: 'db',
  user: 'admin',
  password: 'admin123',
  database: 'demo',
});

// Ruta GET: obtener usuarios
app.get('/users', async (req, res) => {
  try {
    const result = await pool.query('SELECT * FROM users');
    res.json(result.rows);
  } catch (err) {
    res.status(500).send('Error al consultar la base de datos');
  }
});

// Ruta POST: insertar nuevo usuario
app.post('/users', async (req, res) => {
  const { name } = req.body;
  if (!name) return res.status(400).json({ error: "Nombre requerido" });

  try {
    await pool.query('INSERT INTO users (name) VALUES ($1)', [name]);
    res.status(201).json({ message: "Usuario creado" });
  } catch (err) {
    res.status(500).json({ error: "Error al insertar el usuario" });
  }
});

// Iniciar servidor
app.listen(port, () => {
  console.log(`API escuchando en puerto ${port}`);
});
