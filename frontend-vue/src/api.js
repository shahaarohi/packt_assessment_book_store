import axios from 'axios';

//replace with baseurl
const API_URL = 'http://127.0.0.1:8000/api/';


export const ApiService = {
  
  get(path) {
    return axios.get(`${API_URL}${path}`);
  },
  post(path, data) {
    return axios.post(`${API_URL}${path}`, data);
  },
  put(path, data) {
    return axios.put(`${API_URL}${path}`, data);
  },
  delete(path) {
    return axios.delete(`${API_URL}${path}`);
  },  
};
export async function login(credentials) {
    const response = await axios.post(`${API_URL}login`, credentials);
    return response;
}

export async function addNewBook(token, book) {
  const headers = {
    Authorization: `Bearer ${token}`,
    'Content-Type': 'multipart/form-data',
  };

  const response = await axios.post(`${API_URL}books`, book, {
    headers,
  });

  return response;
}

export async function editBook(token, bookID, book) {
  const headers = {
    Authorization: `Bearer ${token}`,
    'Content-Type': 'multipart/form-data',
  };

  const response = await axios.post(`${API_URL}books/${bookID}`, book, {
    headers,
  });

  return response;
}
  
export async function deleteBook(token, bookID) {
  const headers = {
    Authorization: `Bearer ${token}`,
    'Content-Type': 'multipart/form-data',
  };

  const response = await axios.delete(`${API_URL}books/${bookID}`, {
    headers,
  });

  return response;
}