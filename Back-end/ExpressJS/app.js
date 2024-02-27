const initDB = require('./db_connect');
const connection = initDB();

const express = require("express");

const app = express()

app.use(express.json());