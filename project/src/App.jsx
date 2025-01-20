import React from 'react';
import { useAuth } from './hooks/useAuth';
import LoginForm from './components/LoginForm';
import OrderList from './components/OrderList';
import OrderModal from './components/OrderModal';
import TabSelector from './components/TabSelector';
import { useState } from 'react';
import { useOrders } from './hooks/useOrders';

function App() {
  const { user, loading: authLoading, signOut } = useAuth();
  const [activeTab, setActiveTab] = useState('active');
  const [isModalOpen, setIsModalOpen] = useState(false);
  const { products, orders, loading: ordersLoading, addOrder, completeOrder } = useOrders();

  if (authLoading) {
    return <div className="min-h-screen flex items-center justify-center">Loading...</div>;
  }

  if (!user) {
    return <LoginForm />;
  }

  const filteredOrders = orders.filter(order => 
    activeTab === 'active' ? !order.completed : order.completed
  );

  return (
    <div className="min-h-screen bg-gray-100 p-4">
      <div className="max-w-6xl mx-auto">
        <div className="flex justify-between items-center mb-6">
          <div className="flex items-center gap-4">
            <TabSelector activeTab={activeTab} onTabChange={setActiveTab} />
            <button
              onClick={signOut}
              className="text-gray-600 hover:text-gray-800"
            >
              Logout
            </button>
          </div>
          <button
            onClick={() => setIsModalOpen(true)}
            className="bg-teal-600 text-white px-4 py-2 rounded-md flex items-center gap-2 hover:bg-teal-700"
          >
            <span>+</span> Sale Order
          </button>
        </div>

        {ordersLoading ? (
          <div className="text-center py-4">Loading orders...</div>
        ) : (
          <OrderList 
            orders={filteredOrders}
            onCompleteOrder={completeOrder}
          />
        )}

        {products ? (
          <div className="text-center py-4">Loading products...</div>
        ) : (
          <OrderList
            products={products}
            onCompleteOrder={completeOrder}
          />
        )}

        {isModalOpen && (
          <OrderModal
            onClose={() => setIsModalOpen(false)}
            onSubmit={addOrder}
          />
        )}
      </div>
    </div>
  );
}

export default App;