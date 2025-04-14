<template>
  <div class="nk-content">
    <div class="container-fluid">
      <div class="nk-content-inner">
        <div class="nk-content-body">
          <div class="nk-block-head nk-block-head-sm">
            <div class="nk-block-between">
              <div class="nk-block-head-content">
                <h3 class="nk-block-title page-title">Productos</h3>
              </div>
              <div class="nk-block-head-content">
                <div class="toggle-wrap nk-block-tools-toggle">
                  <a href="#" class="btn btn-icon btn-trigger toggle-expand me-n1" data-target="pageMenu"><em class="icon ni ni-more-v"></em></a>
                  <div class="toggle-expand-content" data-content="pageMenu">
                    <ul class="nk-block-tools g-3">
                      <li>
                        <div class="form-control-wrap">
                          <div class="form-icon form-icon-right">
                            <em class="icon ni ni-search"></em>
                          </div>
                            <input 
                            type="text" 
                            class="form-control" 
                            id="default-04" 
                            placeholder="Buscar por nombre" 
                            v-model="searchQuery" 
                            @input="searchProducts"
                          >
                        </div>
                      </li>
                      <li>
                        <div class="drodown">
                          <a href="#" class="dropdown-toggle dropdown-indicator btn btn-outline-light btn-white" data-bs-toggle="dropdown">Estado</a>
                          <div class="dropdown-menu dropdown-menu-end">
                            <ul class="link-list-opt no-bdr">
                              <li><a href="#" @click.prevent="filterByStock('in_stock')"><span>En stock</span></a></li>
                              <li><a href="#" @click.prevent="filterByStock('out_of_stock')"><span>Sin stock</span></a></li>
                              <li><a href="#" @click.prevent="filterByStock('all')"><span>Todos</span></a></li>
                            </ul>
                          </div>
                        </div>
                      </li>
                      <li class="nk-block-tools-opt" @click="openModalPro">
                        <a href="#" data-target="addProduct" class="toggle btn btn-icon btn-primary d-md-none"><em class="icon ni ni-plus"></em></a>
                        <a href="#" data-target="addProduct" class="toggle btn btn-primary d-none d-md-inline-flex"><em class="icon ni ni-plus"></em><span>Agregar Producto</span></a>
                      </li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="nk-block">
            <div class="card card-bordered">
              <div class="card-inner-group">
                <div class="card-inner p-0">
                  <div class="nk-tb-list">
                    <div class="nk-tb-item nk-tb-head">
                      <div class="nk-tb-col"><span>ID</span></div>
                      <div class="nk-tb-col tb-col-sm"><span>Nombre</span></div>
                      <div class="nk-tb-col"><span>Precio</span></div>
                      <div class="nk-tb-col"><span>Stock</span></div>
                      <div class="nk-tb-col"><span>Categoría</span></div>
                      <div class="nk-tb-col"><span>Acciones</span></div>
                    </div>
                    
                    <div class="nk-tb-item" v-for="product in products" :key="product.id">
                      <div class="nk-tb-col">
                        <span class="tb-sub">{{ product.id }}</span>
                      </div>
                      <div class="nk-tb-col tb-col-sm">
                        <span class="title">{{ product.name }}</span>
                      </div>
                      <div class="nk-tb-col">
                        <span class="tb-sub">${{ product.price }}</span>
                      </div>
                      <div class="nk-tb-col">
                        <span class="tb-sub" :class="{ 'text-danger': product.stock <= 0 }">{{ product.stock }}</span>
                      </div>
                      <div class="nk-tb-col">
                        <span class="tb-sub">{{ product.category ? product.category.name : 'Sin categoría' }}</span>
                      </div>
                      <div class="nk-tb-col nk-tb-col-tools">
                        <ul class="nk-tb-actions gx-1">
                          <li>
                            <button class="btn btn-sm btn-icon btn-trigger" title="Editar" @click="openModalPro(product)">
                              <em class="icon ni ni-edit"></em>
                            </button>
                          </li>
                          <li>
                            <button class="btn btn-sm btn-icon btn-trigger text-danger" title="Eliminar" @click="confirmDelete(product.id)">
                              <em class="icon ni ni-trash"></em>
                            </button>
                          </li>
                        </ul>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="card-inner">
                  <div class="nk-block-between-md g-3">
                    <div class="g">
                      <ul class="pagination justify-content-center justify-content-md-start">
                        <li class="page-item" :class="{ disabled: !pagination.prev_page_url }">
                          <a class="page-link" href="#" @click.prevent="fetchProducts(pagination.current_page - 1)">
                            <em class="icon ni ni-chevrons-left"></em>
                          </a>
                        </li>
                        <li class="page-item" v-for="page in pagination.last_page" :key="page" 
                            :class="{ active: page === pagination.current_page }">
                          <a class="page-link" href="#" @click.prevent="fetchProducts(page)">{{ page }}</a>
                        </li>
                        <li class="page-item" :class="{ disabled: !pagination.next_page_url }">
                          <a class="page-link" href="#" @click.prevent="fetchProducts(pagination.current_page + 1)">
                            <em class="icon ni ni-chevrons-right"></em>
                          </a>
                        </li>
                      </ul>
                    </div>
                    <div class="g">
                      <div class="pagination-goto d-flex justify-content-center justify-content-md-start gx-3">
                        <div>Página</div>
                        <div>
                          <select class="form-select" v-model="currentPage" @change="fetchProducts(currentPage)">
                            <option v-for="page in pagination.last_page" :key="page" :value="page">{{ page }}</option>
                          </select>
                        </div>
                        <div>de {{ pagination.last_page }}</div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Modal para productos -->
    <div class="modal fade" id="productModal" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">{{ editingId ? 'Editar' : 'Agregar' }} Producto</h5>
            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close" @click="resetForm">
              <em class="icon ni ni-cross"></em>
            </button>
          </div>
          <div class="modal-body">
            <form @submit.prevent="submitForm">
              <div class="form-group">
                <label class="form-label">Nombre</label>
                <div class="form-control-wrap">
                  <input type="text" class="form-control" v-model="productForm.name" required>
                </div>
              </div>
              <div class="form-group">
                <label class="form-label">Descripción</label>
                <div class="form-control-wrap">
                  <textarea class="form-control" v-model="productForm.description"></textarea>
                </div>
              </div>
              <div class="form-group">
                <label class="form-label">Precio</label>
                <div class="form-control-wrap">
                  <input type="number" step="0.01" class="form-control" v-model="productForm.price" required>
                </div>
              </div>
              <div class="form-group">
                <label class="form-label">Stock</label>
                <div class="form-control-wrap">
                  <input type="number" class="form-control" v-model="productForm.stock" required>
                </div>
              </div>
              <div class="form-group">
                <label class="form-label">Categoría</label>
                <div class="form-control-wrap">
                  <select class="form-control" v-model="productForm.category_id" required>
                    <option v-for="category in categories" :key="category.id" :value="category.id">
                      {{ category.name }}
                    </option>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <button type="submit" class="btn btn-lg btn-primary">
                  {{ editingId ? 'Actualizar' : 'Guardar' }}
                </button>
              </div>
            </form>
          </div>
          <div class="modal-footer bg-light">
            <span class="sub-text">Modal Footer Text</span>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { Modal } from "bootstrap";
import axios from "axios";
import Swal from 'sweetalert2';

export default {
  data() {
    return {
      products: [],  
      pagination: {  
        current_page: 1,
        last_page: 1,
        prev_page_url: null,
        next_page_url: null,
      },
      categories: [],  
      productForm: {  
        name: '',
        description: '',
        price: 0,
        stock: 0,
        category_id: null
      },
      modalInstance: null,  
      editingId: null,  
      currentPage: 1,  
      searchQuery: '',  
      stockFilter: 'all',  
      searchTimer: null  
    };
  },
  mounted() {
 
    this.modalInstance = new Modal(document.getElementById('productModal'));
    this.fetchProducts();
    this.fetchCategories();
  },
  methods: {
    async fetchProducts(page = 1) {
      try {
        const token = localStorage.getItem("token");
        let params = {
          page: page
        };
        
        if (this.searchQuery) {
          params.search = this.searchQuery;
        }
        if (this.stockFilter !== 'all') {
          params.stock = this.stockFilter;
        }
        
        const response = await axios.get("/api/products", {
          params: params,
          headers: {
            Authorization: `Bearer ${token}`
          }
        });
        
        this.products = response.data.data;
        this.pagination = {
          current_page: response.data.current_page,
          last_page: response.data.last_page,
          prev_page_url: response.data.prev_page_url,
          next_page_url: response.data.next_page_url
        };
        this.currentPage = response.data.current_page;
      } catch (error) {
        console.error("Error al obtener productos:", error.response?.data || error);
        Swal.fire({
          icon: 'error',
          title: 'Error',
          text: 'No se pudieron cargar los productos',
          confirmButtonText: 'Entendido'
        });
      }
    },
    
    searchProducts() {
       clearTimeout(this.searchTimer);
      this.searchTimer = setTimeout(() => {
        this.fetchProducts(1);  
      }, 500);
    },
    
    filterByStock(filter) {
      this.stockFilter = filter;
      this.fetchProducts(1);  
    },
    async fetchCategories() {
      try {
        const token = localStorage.getItem("token");
        const response = await axios.get('/api/categories', {
          headers: { Authorization: `Bearer ${token}` }
        });
        this.categories = response.data.data;
        
        if (this.categories.length > 0) {
          this.productForm.categoria_id = this.categories[0].id;
        }
      } catch (error) {
        console.error("Error al obtener categorías:", error);
      }
    },

    openModalPro(product = null) {
      if (product) {
         this.editingId = product.id;
        this.productForm = {
          name: product.name,
          description: product.description,
          price: product.price,
          stock: product.stock,
          category_id: product.category_id
        };
      } else {
        this.resetForm();
      }
      this.modalInstance.show();
    },
    
    resetForm() {
      this.editingId = null;
      this.productForm = {
        name: '',
        description: '',
        price: 0,
        stock: 0,
        category_id: this.categories.length > 0 ? this.categories[0].id : null
      };
    },
    
    async submitForm() {
      try {
        const token = localStorage.getItem("token");
        let request;
        
        if (this.editingId) {
           request = axios.put(
            `/api/products/${this.editingId}`, 
            this.productForm,
            { headers: { Authorization: `Bearer ${token}` } }
          );
        } else {
           request = axios.post(
            '/api/products', 
            this.productForm,
            { headers: { Authorization: `Bearer ${token}` } }
          );
        }

        const response = await request;
        this.modalInstance.hide();
        
        await Swal.fire({
          icon: 'success',
          title: 'Éxito',
          text: `Producto ${this.editingId ? 'actualizado' : 'creado'} correctamente`,
          confirmButtonText: 'Aceptar'
        });
        
        this.resetForm();
        this.fetchProducts();
      } catch (error) {
        console.error("Error:", error);
        Swal.fire({
          icon: 'error',
          title: 'Error',
          text: error.response?.data?.message || 'Ocurrió un error',
          confirmButtonText: 'Entendido'
        });
      }
    },
    
    confirmDelete(id) {
      Swal.fire({
        title: '¿Estás seguro?',
        text: "¡No podrás revertir esta acción!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
      }).then((result) => {
        if (result.isConfirmed) {
          this.deleteProduct(id);
        }
      });
    },
    
    async deleteProduct(id) {
      try {
        const token = localStorage.getItem("token");
        await axios.delete(`/api/products/${id}`, {
          headers: { Authorization: `Bearer ${token}` }
        });
        
        await Swal.fire('Eliminado', 'El producto ha sido eliminado', 'success');
        this.fetchProducts();
      } catch (error) {
        console.error("Error:", error);
        Swal.fire('Error', 'No se pudo eliminar el producto', 'error');
      }
    },
    
    searchProducts() {
      clearTimeout(this.searchTimer);
      this.searchTimer = setTimeout(() => {
        this.fetchProducts();
      }, 500);
    },
    
    filterByStock(filter) {
      this.stockFilter = filter;
      this.fetchProducts();
    }
  }
};
</script>

<style scoped>
.text-danger {
  color: #f44336;
}
</style>