<template>
  <div class="nk-content ">
    <div class="container-fluid">
        <div class="nk-content-inner">
            <div class="nk-content-body">
                <div class="nk-block-head nk-block-head-sm">
                    <div class="nk-block-between">
                        <div class="nk-block-head-content">
                            <h3 class="nk-block-title page-title">Categories</h3>
                        </div><!-- .nk-block-head-content -->
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
                                                  placeholder="Quick search by id or name"
                                                  v-model="searchTerm"
                                                  @input="handleSearch"
                                                >
                                            </div>
                                        </li>
                                        <li>
                                            <div class="drodown">
                                                <a href="#" class="dropdown-toggle dropdown-indicator btn btn-outline-light btn-white" data-bs-toggle="dropdown">Status</a>
                                                <div class="dropdown-menu dropdown-menu-end">
                                                    <ul class="link-list-opt no-bdr">
                                                        <li><a href="#"><span>New Items</span></a></li>
                                                        <li><a href="#"><span>Featured</span></a></li>
                                                        <li><a href="#"><span>Out of Stock</span></a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="nk-block-tools-opt"   @click="openModal">
                                            <a href="#" data-target="addProduct" class="toggle btn btn-icon btn-primary d-md-none"><em class="icon ni ni-plus"></em></a>
                                            <a href="#" data-target="addProduct" class="toggle btn btn-primary d-none d-md-inline-flex"><em class="icon ni ni-plus"></em><span>Add Category</span></a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div><!-- .nk-block-head-content -->
                    </div><!-- .nk-block-between -->
                </div><!-- .nk-block-head -->
                <div class="nk-block">
                    <div class="card card-bordered">
                        <div class="card-inner-group">
                            <div class="card-inner p-0">
                                <div class="nk-tb-list">
                                    <div class="nk-tb-item nk-tb-head">
                                      <div class="nk-tb-col"><span>ID</span></div>
                                      <div class="nk-tb-col tb-col-sm"><span>Nombre</span></div>
                                      <div class="nk-tb-col"><span>Acciones</span></div>
                                    </div><!-- .nk-tb-item -->
                                    <div class="nk-tb-item" v-for="category in categories.data" :key="category.id">
                                      <div class="nk-tb-col">
                                        <span class="tb-sub">{{ category.id }}</span>
                                      </div>
                                      <div class="nk-tb-col tb-col-sm">
                                        <span class="title">{{ category.name }}</span>
                                      </div>
                                      <div class="nk-tb-col nk-tb-col-tools">
                                        <ul class="nk-tb-actions gx-1">
                                          <li>
                                            <button class="btn btn-sm btn-icon btn-trigger" title="Editar" @click="openModal(category)">
                                              <em class="icon ni ni-edit"></em>
                                            </button>
                                          </li>
                                          <li>
                                            <button class="btn btn-sm btn-icon btn-trigger text-danger" title="Eliminar" @click="confirmDelete(category.id)">
                                              <em class="icon ni ni-trash"></em>
                                            </button>
                                          </li>
                                        </ul>
                                      </div>
                                    </div><!-- .nk-tb-item -->
                           
                                </div><!-- .nk-tb-list -->
                            </div>
                            <div class="card-inner">
                                <div class="nk-block-between-md g-3">
                                  <div class="g">
                                    <ul class="pagination justify-content-center justify-content-md-start">
                                      <li class="page-item" :class="{ disabled: !categories.prev_page_url }">
                                        <a class="page-link" href="#" @click.prevent="fetchCategories(categories.current_page - 1)">
                                          <em class="icon ni ni-chevrons-left"></em>
                                        </a>
                                      </li>
                                      
                                      <li class="page-item" v-for="page in categories.last_page" :key="page" 
                                          :class="{ active: page === categories.current_page }">
                                        <a class="page-link" href="#" @click.prevent="fetchCategories(page)">{{ page }}</a>
                                      </li>
                                      
                                      <li class="page-item" :class="{ disabled: !categories.next_page_url }">
                                        <a class="page-link" href="#" @click.prevent="fetchCategories(categories.current_page + 1)">
                                          <em class="icon ni ni-chevrons-right"></em>
                                        </a>
                                      </li>
                                    </ul>
                                  </div>
                                  
                                  <div class="g">
                                    <div class="pagination-goto d-flex justify-content-center justify-content-md-start gx-3">
                                      <div>Página</div>
                                      <div>
                                        <select class="form-select" v-model="currentPage" @change="fetchCategories(currentPage)">
                                          <option v-for="page in categories.last_page" :key="page" :value="page">{{ page }}</option>
                                        </select>
                                      </div>
                                      <div>de {{ categories.last_page }}</div>
                                    </div>
                                  </div>
                                </div><!-- .nk-block-between -->
                            </div>
                        </div>
                    </div>
                </div><!-- .nk-block -->
                <div class="nk-add-product toggle-slide toggle-slide-right toggle-screen-any" data-content="addProduct" data-toggle-screen="any" data-toggle-overlay="true" data-toggle-body="true" data-simplebar="init"><div class="simplebar-wrapper" style="margin: -24px;"><div class="simplebar-height-auto-observer-wrapper"><div class="simplebar-height-auto-observer"></div></div><div class="simplebar-mask"><div class="simplebar-offset" style="right: 0px; bottom: 0px;"><div class="simplebar-content-wrapper" tabindex="0" role="region" aria-label="scrollable content" style="height: 100%; overflow: hidden scroll;"><div class="simplebar-content" style="padding: 24px;">
                   
                </div></div></div></div><div class="simplebar-placeholder" style="width: auto; height: 699px;"></div></div><div class="simplebar-track simplebar-horizontal" style="visibility: hidden;"><div class="simplebar-scrollbar" style="width: 0px; display: none;"></div></div><div class="simplebar-track simplebar-vertical" style="visibility: visible;"><div class="simplebar-scrollbar" style="height: 222px; transform: translate3d(0px, 0px, 0px); display: block;"></div></div></div>
            </div>
        </div>
    </div>
</div>

   <!-- Modal -->
   <div class="modal fade" id="modalForm" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Add Category</h5>
          <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
            <em class="icon ni ni-cross"></em>
          </button>
        </div>
        <div class="modal-body">
          <form @submit.prevent="submitForm">
              <div class="form-group">
                  <label class="form-label" for="full-name">Nombre</label>
                  <div class="form-control-wrap">
             <input type="text" class="form-control" id="full-name" v-model="CategoryName" required>
                  </div>
              </div>
              <div class="form-group">
                  <button type="submit" class="btn btn-lg btn-primary">Save Informations</button>
              </div>
          </form>
        </div>
        <div class="modal-footer bg-light">
          <span class="sub-text">Modal Footer Text</span>
        </div>
      </div>
    </div>
  </div>
  <!-- Fin Modal -->
 
</template>

<script>
import { Modal } from "bootstrap";
import axios from "axios";
import Swal from 'sweetalert2';

export default {
  data() {
    return {
      CategoryName: "",
      searchTerm: "", 
      modalInstance: null,
      categories: {
        data: [],
        current_page: 1,
        last_page: 1,
        prev_page_url: null,
        next_page_url: null,
      },
      currentPage: 1,
      editingId: null  
    };
  }, mounted() {
    this.fetchCategories();
  },
  methods: {

    resetForm() {
      this.editingId = null;
      this.CategoryName = "";
    },
    
    openModal(category = null) {
      if (category) {
        this.editingId = category.id;
        this.CategoryName = category.name;
      } else {
        this.resetForm();
      }
      
      let modalElement = document.getElementById("modalForm");
      this.modalInstance = new Modal(modalElement);
      
      const modalTitle = modalElement.querySelector('.modal-title');
      if (modalTitle) {
        modalTitle.textContent = this.editingId ? 'Editar Categoría' : 'Agregar Categoría';
      }
      
      this.modalInstance.show();
    },
    
    async submitForm() {
      try {
        const token = localStorage.getItem("token");
        let response;
        
        if (this.editingId) {
          response = await axios.put(
            `/api/categories/${this.editingId}`,
            { name: this.CategoryName },
            { headers: { Authorization: `Bearer ${token}` } }
          );
        } else {
          response = await axios.post(
            "/api/categories",
            { name: this.CategoryName },
            { headers: { Authorization: `Bearer ${token}` } }
          );
        }

        if (this.modalInstance) {
          this.modalInstance.hide();
        }
        
        await Swal.fire({
          icon: 'success',
          title: 'Éxito',
          text: this.editingId 
            ? 'Categoría actualizada correctamente' 
            : 'Categoría creada correctamente',
          confirmButtonText: 'Aceptar'
        });

        this.resetForm();
        this.fetchCategories();
        
      } catch (error) {
        console.error("Error:", error.response?.data || error);
        
        let errorMessage = 'Ocurrió un error';
        if (error.response?.data?.message) {
          errorMessage = error.response.data.message;
        } else if (error.response?.data?.errors?.name) {
          errorMessage = error.response.data.errors.name[0];
        }

        Swal.fire({
          icon: 'error',
          title: 'Error',
          text: errorMessage,
          confirmButtonText: 'Entendido'
        });
      }
    },

    handleSearch() {
    clearTimeout(this.searchTimeout);
    this.searchTimeout = setTimeout(() => {
      this.fetchCategories();
    }, 500); 
  },
        
    async fetchCategories(page = 1) {
      try {
        const token = localStorage.getItem("token");
        let url = `/api/categories?page=${page}`;
        
  
        if (this.searchTerm) {
          url += `&search=${this.searchTerm}`;
        }
        
        const response = await axios.get(url, {
          headers: {
            Authorization: `Bearer ${token}`
          }
        });
        
        this.categories = response.data;
        this.currentPage = response.data.current_page;
      } catch (error) {
        console.error("Error al obtener categorías:", error.response?.data || error);
        Swal.fire({
          icon: 'error',
          title: 'Error',
          text: 'No se pudieron cargar las categorías',
          confirmButtonText: 'Entendido'
        });
      }
    },
        
    
      async editCategory(category) {
       
        this.CategoryName = category.name;
        this.editingId = category.id;  
        
        let modalElement = document.getElementById("modalForm");
        this.modalInstance = new Modal(modalElement);
        this.modalInstance.show();
        
       
        const modalTitle = modalElement.querySelector('.modal-title');
        if (modalTitle) {
          modalTitle.textContent = 'Editar Categoría';
        }
      },

      async confirmDelete(categoryId) {
        const result = await Swal.fire({
          title: '¿Estás seguro?',
          text: "¡No podrás revertir esta acción!",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#d33',
          cancelButtonColor: '#3085d6',
          confirmButtonText: 'Sí, eliminar',
          cancelButtonText: 'Cancelar'
        });

        if (result.isConfirmed) {
          await this.deleteCategory(categoryId);
        }
      },

      async deleteCategory(categoryId) {
        try {
          const token = localStorage.getItem("token");
          await axios.delete(`/api/categories/${categoryId}`, {
            headers: {
              Authorization: `Bearer ${token}`
            }
          });

          await Swal.fire({
            icon: 'success',
            title: '¡Eliminado!',
            text: 'La categoría ha sido eliminada correctamente.',
            confirmButtonText: 'Aceptar'
          });

          this.fetchCategories();
        } catch (error) {
          console.error("Error al eliminar la categoría:", error);
          Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'No se pudo eliminar la categoría',
            confirmButtonText: 'Entendido'
          });
        }
      },
  },
};
</script>