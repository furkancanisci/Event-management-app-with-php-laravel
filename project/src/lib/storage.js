// Local storage keys
const STORAGE_KEYS = {
  ORDERS: 'orders',
  USER: 'user'
};

// User management
export const getUser = () => {
  const user = localStorage.getItem(STORAGE_KEYS.USER);
  return user ? JSON.parse(user) : null;
};

export const login = (email, password) => {
  // Simple demo login - in real app would validate against backend
  if (email && password) {
    const user = { id: '1', email };
    localStorage.setItem(STORAGE_KEYS.USER, JSON.stringify(user));
    return user;
  }
  throw new Error('Invalid credentials');
};

export const register = (email, password) => {
  // Simple demo registration
  if (email && password) {
    const user = { id: '1', email };
    localStorage.setItem(STORAGE_KEYS.USER, JSON.stringify(user));
    return user;
  }
  throw new Error('Invalid credentials');
};

export const logout = () => {
  localStorage.removeItem(STORAGE_KEYS.USER);
};

// Order management
export const getOrders = () => {
  const orders = localStorage.getItem(STORAGE_KEYS.ORDERS);
  return orders ? JSON.parse(orders) : [];
};

export const getProducts = () => {
  const products = localStorage.getItem(STORAGE_KEYS.PRODUCTS);
  return products ? JSON.parse(products) : [];
};

export const addOrder = (orderData) => {
  const orders = getOrders();
  const newOrder = {
    id: crypto.randomUUID(),
    ...orderData,
    created_at: new Date().toISOString()
  };
  
  orders.unshift(newOrder);
  localStorage.setItem(STORAGE_KEYS.ORDERS, JSON.stringify(orders));
  return newOrder;
};

export const completeOrder = (orderId) => {
  const orders = getOrders();
  const updatedOrders = orders.map(order =>
    order.id === orderId ? { ...order, completed: true } : order
  );
  localStorage.setItem(STORAGE_KEYS.ORDERS, JSON.stringify(updatedOrders));
};