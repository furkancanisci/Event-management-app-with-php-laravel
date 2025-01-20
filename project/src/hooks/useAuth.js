import { useState, useEffect } from 'react';
import { getUser, login, register, logout } from '../lib/storage';

export function useAuth() {
  const [user, setUser] = useState(null);
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    setUser(getUser());
    setLoading(false);
  }, []);

  const signIn = async (email, password) => {
    try {
      const user = login(email, password);
      setUser(user);
      location.reload();
    } catch (error) {
      throw error;
    }
  };

  const signUp = async (email, password) => {
    try {
      const user = register(email, password);
      setUser(user);
    } catch (error) {
      throw error;
    }
  };

  const signOut = () => {
    logout();
    setUser(null);
  };

  return {
    user,
    loading,
    signIn,
    signUp,
    signOut
  };
}