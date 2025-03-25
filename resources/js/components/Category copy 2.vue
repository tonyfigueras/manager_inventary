<template>
    <div>
      Categories
    </div>
  </template>
  
  <script>
  export default {
    data: () => ({
  
    }),
  };
  </script>




<div>
  <h1>Dashboard</h1>
  <p>Bienvenido al panel de control.</p>
</div>

<RouterLink :to="{name: 'Category'}">Dashboard</RouterLink>
<RouterLink :to="{name: 'Products'}">Products</RouterLink>
<RouterView />