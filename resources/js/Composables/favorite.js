import axios from "axios"

export async function useFavorite(id) {
  return axios.post(route('apartments.favorite', { apartment: id }))
    .then(({ data }) => {
      return data.is_favorite
    }).catch(error => {   
      return false
    });
}