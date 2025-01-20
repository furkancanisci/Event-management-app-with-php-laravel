CREATE TABLE users (
  id SERIAL PRIMARY KEY,
  email VARCHAR(255) UNIQUE NOT NULL,
  password VARCHAR(255) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE orders (
  id SERIAL PRIMARY KEY,
  user_id INTEGER REFERENCES users(id),
  customer_name VARCHAR(255) NOT NULL,
  total_price DECIMAL(10,2) NOT NULL,
  last_modified TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  completed BOOLEAN DEFAULT FALSE,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE products (
	id serial4 NOT NULL,
	productname varchar(100) NULL,
	stock int4 NULL,
	price numeric NULL,
	CONSTRAINT products_pkey PRIMARY KEY (id)
);