import { pool } from './db.js';

export const getOrders = async (userId) => {
  const result = await pool.query(
    'SELECT * FROM orders WHERE user_id = $1 ORDER BY created_at DESC',
    [userId]
  );
  return result.rows;
};

export const getProducts = async (userId) => {
  const result = await pool.query(
    'SELECT * FROM products'
  );
  return result.rows;
};

export const addOrder = async (orderData, userId) => {
  const { customerName, totalPrice } = orderData;
  const result = await pool.query(
    `INSERT INTO orders (user_id, customer_name, total_price) 
     VALUES ($1, $2, $3) 
     RETURNING *`,
    [userId, customerName, totalPrice]
  );
  return result.rows[0];
};

export const completeOrder = async (orderId, userId) => {
  const result = await pool.query(
    `UPDATE orders 
     SET completed = true 
     WHERE id = $1 AND user_id = $2 
     RETURNING *`,
    [orderId, userId]
  );
  return result.rows[0];
};