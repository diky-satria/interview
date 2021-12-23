@extends('layout.app2')

@push('css')
<link rel="stylesheet" href="{{ asset('assets/css/datatable.css') }}">
@endpush

@section('title')
produk
@endsection

@section('content')
<div id="component">

    <div class="row">
        <div class="col-md">
            <a href="{{ url('dashboard') }}" class="btn btn-sm btn-dark mb-3">Kembali</a>
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h5>Produk</h5>
                    <button class="btn btn-sm btn-primary" @click="tambah" data-bs-toggle="modal" data-bs-target="#staticBackdrop">Tambah</button>
                </div>
                <div class="card-body">
                    <table class="table table-sm" id="table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Harga</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" v-if="!editMode" id="staticBackdropLabel">Tambah</h5>
                    <h5 class="modal-title" v-if="editMode" id="staticBackdropLabel">Edit</h5>
                    <button type="button" @click="tutup_modal" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <form @submit.prevent="!editMode ? actionTambah() : actionEdit(dataEdit.id)" id="form">
                        <div class="form-group mb-3">
                            <label>Nama</label>
                            <!-- tambah -->
                            <input type="text" v-if="!editMode" name="name" class="form-control" id="name">
                            <!-- edit -->
                            <input type="text" v-if="editMode" name="name" v-model="dataEdit.name" class="form-control" id="name">

                            <div class="form-text text-danger" v-if="errors['name']">@{{ errors['name'][0] }}</div>
                        </div>
                        <div class="form-group mb-3">
                            <label>Harga</label>
                            <!-- tambah -->
                            <input type="text" v-if="!editMode" name="price" class="form-control" id="price">
                            <!-- edit -->
                            <input type="text" v-if="editMode" name="price" v-model="dataEdit.price" class="form-control" id="price">

                            <div class="form-text text-danger" v-if="errors['price']">@{{ errors['price'][0] }}</div>
                        </div>
                        <button class="btn btn-sm btn-primary float-end d-flex" id="btn-submit">
                            <div v-if="!editMode">Tambah</div>
                            <div v-if="editMode">Edit</div>
                            <svg v-if="load" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" style="margin: auto; background: rgba(255, 255, 255, 0); display: block; shape-rendering: auto;" width="24px" height="22px" viewBox="0 0 100 100" preserveAspectRatio="xMidYMid">
                                    <g>
                                        <path d="M50 15A35 35 0 1 0 74.74873734152916 25.251262658470843" fill="none" stroke="#ffffff" stroke-width="12"></path>
                                        <path d="M49 3L49 27L61 15L49 3" fill="#ffffff"></path>
                                        <animateTransform attributeName="transform" type="rotate" repeatCount="indefinite" dur="1s" values="0 50 50;360 50 50" keyTimes="0;1"></animateTransform>
                                    </g>
                            </svg>
                        </button>
                    </form>

                </div>
            </div>
        </div>
    </div>

</div>
@endsection

@push('js')
<script src="{{ asset('assets/js/datatable.js') }}"></script>
<script>
    var component = new Vue({
        el: '#component',
        data: {
            editMode: false,
            errors: [],
            load: false,
            dataEdit: {}
        },
        mounted(){
            this.ambilData()
        },
        methods:{
            ambilData(){
                $('#table').DataTable({
                    serverSide: true,
                    processing: true,
                    language: {
                        url: '{{ asset("assets/json/datatable_language.json") }}'
                    },
                    ajax: {
                        url: 'produk',
                    },
                    columns: [
                        {
                        "data" : null, "sortable" : false,
                        render: function(data, type, row, meta){
                            return meta.row + meta.settings._iDisplayStart + 1
                        }
                        },
                        {data: 'name', name: 'name'},
                        {data: 'price', name: 'price'},
                        {data: 'aksi', name: 'aksi'}
                    ]
                })
            },
            tutup_modal(){
                this.errors = []
                $('#name').val('')
                $('#price').val('')
            },
            tambah(){
                this.editMode = false
            },
            async actionTambah(){
                let btn = document.getElementById('btn-submit')
                this.errors = []
                try{
                    btn.setAttribute('disabled', true)
                    this.load = true

                    await axios.post('produk', new FormData($('#form')[0]))
                    $('#table').DataTable().ajax.reload()
                    $('.btn-close').click()

                    Toast.fire({
                        icon: 'success',
                        title: 'Produk berhasil ditambahkan'
                    })

                    btn.removeAttribute('disabled', false)
                    this.load = false
                }catch(e){
                    this.errors = e.response.data.errors
                    btn.removeAttribute('disabled', false)
                    this.load = false
                }
            },
            async edit(id){
                this.editMode = true
                let response = await axios.get('produk/'+ id)
                this.dataEdit = response.data.data
            },
            async actionEdit(id){
                let btn = document.getElementById('btn-submit')
                this.errors = []
                try{
                    btn.setAttribute('disabled', true)
                    this.load = true

                    await axios.patch('produk/'+ id, this.dataEdit)
                    $('#table').DataTable().ajax.reload()
                    $('.btn-close').click()

                    Toast.fire({
                        icon: 'success',
                        title: 'Produk berhasil di edit'
                    })

                    btn.removeAttribute('disabled', false)
                    this.load = false
                }catch(e){
                    this.errors = e.response.data.errors
                    btn.removeAttribute('disabled', false)
                    this.load = false
                }
            },
            hapus(id){
                Swal.fire({
                    title: 'Apa kamu yakin?',
                    text: "ingin menghapus produk ini",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, Hapus',
                    cancelButtonText: 'Kembali',
                    cancelButtonColor: 'black'
                    }).then((result) => {
                    if (result.isConfirmed) {

                        axios.delete('produk/'+ id)
                        $('#table').DataTable().ajax.reload()

                        Toast.fire({
                            icon: 'success',
                            title: 'Produk berhasil di hapus'
                        })
                    }
                })
            }
        }
    })
</script>
@endpush