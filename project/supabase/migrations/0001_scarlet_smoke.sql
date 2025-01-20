/*
  # Create orders table and auth schema

  1. New Tables
    - `orders`
      - `id` (uuid, primary key)
      - `user_id` (uuid, references auth.users)
      - `customer_name` (text)
      - `total_price` (numeric)
      - `last_modified` (timestamp)
      - `completed` (boolean)
      - `created_at` (timestamp)

  2. Security
    - Enable RLS on `orders` table
    - Add policies for CRUD operations
*/

CREATE TABLE orders (
  id uuid PRIMARY KEY DEFAULT gen_random_uuid(),
  user_id uuid REFERENCES auth.users NOT NULL,
  customer_name text NOT NULL,
  total_price numeric NOT NULL,
  last_modified timestamptz DEFAULT now(),
  completed boolean DEFAULT false,
  created_at timestamptz DEFAULT now()
);

CREATE TABLE products (
	id serial4 NOT NULL,
	productname varchar(100) NULL,
	stock int4 NULL,
	price numeric NULL,
	CONSTRAINT products_pkey PRIMARY KEY (id)
);

ALTER TABLE orders ENABLE ROW LEVEL SECURITY;

-- Allow users to read their own orders
CREATE POLICY "Users can read own orders"
  ON orders
  FOR SELECT
  TO authenticated
  USING (auth.uid() = user_id);

-- Allow users to insert their own orders
CREATE POLICY "Users can insert own orders"
  ON orders
  FOR INSERT
  TO authenticated
  WITH CHECK (auth.uid() = user_id);

-- Allow users to update their own orders
CREATE POLICY "Users can update own orders"
  ON orders
  FOR UPDATE
  TO authenticated
  USING (auth.uid() = user_id);