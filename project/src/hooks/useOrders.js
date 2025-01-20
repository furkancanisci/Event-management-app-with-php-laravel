import { useState, useEffect } from 'react';
import { getOrders as getStoredOrders, addOrder as addStoredOrder, completeOrder as completeStoredOrder } from '../lib/storage';
import { getProducts as products } from '../lib/storage';

export function useOrders() {
  const [orders, setOrders] = useState([]);
  const [products, setProducts] = useState([]);
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    fetchOrders();
  }, []);

  useEffect(() => {
    fetchProducts();
  }, []);

  const fetchOrders = () => {
    try {
      const data = getStoredOrders();
      setOrders(data);
    } catch (error) {
      console.error('Error fetching orders:', error);
    } finally {
      setLoading(false);
    }
  };

  const fetchProducts = () => {
    try {
      const data = products();
      setProducts(data);
    } catch (error) {
      console.error('Error fetching orders:', error);
    } finally {
      setLoading(false);
    }
  };

  const addOrder = async (orderData) => {
    try {
      const newOrder = addStoredOrder(orderData);
      setOrders(prev => [newOrder, ...prev]);
      return newOrder;
    } catch (error) {
      console.error('Error adding order:', error);
      throw error;
    }
  };

  const completeOrder = async (orderId) => {
    try {
      completeStoredOrder(orderId);
      setOrders(prev =>
        prev.map(order =>
          order.id === orderId
            ? { ...order, completed: true }
            : order
        )
      );
    } catch (error) {
      console.error('Error completing order:', error);
      throw error;
    }
  };

  return { products, orders, loading, addOrder, completeOrder };
}