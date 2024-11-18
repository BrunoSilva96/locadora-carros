<template>
  <div class="container">
      <div class="row justify-content-center">
          <div class="col-md-8">
            <!-- Início do card de busca -->
            <card-component titulo="Busca de marcas">
              <template v-slot:conteudo>
                <div class="row">
                  <div class="col mb-3">
                    <input-container-component titulo="ID" id="inputId"idHelp="idHelp"texto-ajuda="Opcional. Informe o Id da marca.">
                      <input type="number" class="form-control" id="inputId" aria-describedby="idHelp" placeholder="ID">
                    </input-container-component>

                  </div>
                  <div class="col mb-3">
                    <input-container-component titulo="Nome" id="inputNome"idHelp="idHelp"texto-ajuda="Opcional. Informe o Nome da marca.">
                    <input type="text" class="form-control"Nome="inputNome" aria-describedby="nomeHelp" placeholder="Nome da marca">
                    </input-container-component>
                  </div>
                </div>
              </template>  
              <template v-slot:rodape>
                <button type="submit" class="btn btn-primary btn-sm float-end">Pesquisar</button>
              </template>
            </card-component>
              
            <!-- Fim do card de busca -->

            <!-- Início do card de listagem de marcas -->
            <card-component titulo="Relação de marcas">
              <template v-slot:conteudo>
                <table-component></table-component>
              </template>
              <template v-slot:rodape>
                <button type="button" class="btn btn-primary btn-sm float-end">Adicionar</button>
              </template>
            </card-component>  
            <!-- Fim do card de listagem de marcas -->
          </div>
      </div>
  </div>
</template>

<script>
</script>