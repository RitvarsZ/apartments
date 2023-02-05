import axios from "axios"

export async function useSeen(id) {
  return axios.post(route('apartments.seen', { apartment: id }))
    .then(response => {
      return response.data
    }).catch(error => {   
      return error.message
    });
}