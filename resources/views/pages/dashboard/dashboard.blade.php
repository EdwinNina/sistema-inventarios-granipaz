<x-app-layout>
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
        <div class="grid grid-cols-1 sm:grid-cols-4">
            <div class="card w-80 bg-base-100 shadow-xl">
                <div class="card-body flex justify-between flex-row items-center">
                    <div>
                        <h2 class="text-blue-500 font-bold">Cantidad de Productos</h2>
                        <p class="card-title">{{ $cantidad_productos }}</p>
                    </div>
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke-width="1.5" stroke="currentColor" class="w-16 h-16 text-blue-500 opacity-60">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M6.429 9.75L2.25 12l4.179 2.25m0-4.5l5.571 3 5.571-3m-11.142 0L2.25 7.5 12 2.25l9.75 5.25-4.179 2.25m0 0L21.75 12l-4.179 2.25m0 0l4.179 2.25L12 21.75 2.25 16.5l4.179-2.25m11.142 0l-5.571 3-5.571-3" />
                        </svg>
                    </div>
                </div>
            </div>
            <div class="card w-80 bg-base-100 shadow-xl">
                <div class="card-body flex justify-between flex-row items-center">
                    <div>
                        <h2 class="text-blue-500 font-bold">Compras Realizadas</h2>
                        <p class="card-title">{{ $compras_realizadas }}</p>
                    </div>
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke-width="1.5" stroke="currentColor" class="w-16 h-16 text-blue-500 opacity-60">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z" />
                        </svg>
                    </div>
                </div>
            </div>
            <div class="card w-80 bg-base-100 shadow-xl">
                <div class="card-body flex justify-between flex-row items-center">
                    <div>
                        <h2 class="text-blue-500 font-bold">Ventas Realizadas</h2>
                        <p class="card-title">{{ $ventas_realizadas }}</p>
                    </div>
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke-width="1.5" stroke="currentColor" class="w-16 h-16 text-blue-500 opacity-60">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M8.25 18.75a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 01-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h1.125c.621 0 1.129-.504 1.09-1.124a17.902 17.902 0 00-3.213-9.193 2.056 2.056 0 00-1.58-.86H14.25M16.5 18.75h-2.25m0-11.177v-.958c0-.568-.422-1.048-.987-1.106a48.554 48.554 0 00-10.026 0 1.106 1.106 0 00-.987 1.106v7.635m12-6.677v6.677m0 4.5v-4.5m0 0h-12" />
                        </svg>
                    </div>
                </div>
            </div>
            <div class="card w-80 bg-base-100 shadow-xl">
                <div class="card-body flex justify-between flex-row items-center">
                    <div>
                        <h2 class="text-blue-500 font-bold">Total de ventas hoy</h2>
                        <p class="card-title">{{ $total_ventas_hoy }}</p>
                    </div>
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-16 h-16 text-blue-500 opacity-60">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 00-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 01-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 003 15h-.75M15 10.5a3 3 0 11-6 0 3 3 0 016 0zm3 0h.008v.008H18V10.5zm-12 0h.008v.008H6V10.5z" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>
        <div class="grid grid-cols-1 mt-8">
            <div class="card w-full bg-base-100 shadow-xl">
                <div class="card-body">
                    <h2 class="card-title flex justify-center">CANTIDAD DE DINERO INGRESADO EN EL MES ACTUAL</h2>
                    <div class="flex flex-col gap-3 justify-between md:flex-row md:items-end md:m-5">
                        <div class="flex-1">
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">Fecha Inicio</label>
                            <div class="relative">
                                <div class="flex absolute inset-y-0 left-0 items-center pl-3 pointer-events-none">
                                    @include('components/icons/date')
                                </div>
                                <input type="date" id="fecha_inicio"
                                    class="block p-3 pl-10 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700">
                            </div>
                        </div>
                        <div class="flex-1">
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">Fecha Fin</label>
                            <div class="relative">
                                <div class="flex absolute inset-y-0 left-0 items-center pl-3 pointer-events-none">
                                    @include('components/icons/date')
                                </div>
                                <input type="date" id="fecha_fin"
                                    class="block p-3 pl-10 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700">
                            </div>
                        </div>
                        <div class="flex justify-end mt-4 md:mt-0">
                            <button type="button" id="btnBuscar"
                                class="p-2 bg-blue-600 text-white flex justify-center items-center rounded-md shadow-md
                                    hover:bg-blue-700 ml-2 md:mb-1">
                                @include('components/icons/search')
                            </button>
                            <button type="button" id="btnLimpiar"
                                class="p-2 bg-purple-600 text-white flex justify-center items-center rounded-md shadow-md
                                    hover:bg-purple-700 ml-2 md:mb-1">
                                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </button>
                        </div>
                    </div>
                    <div id="ingresosMes"></div>
                </div>
            </div>
        </div>
        <div class="grid grid-cols-1 mt-8">
            <div class="card w-full bg-base-100 shadow-xl">
                <div class="card-body">
                    <h2 class="card-title flex justify-center">CANTIDAD DE DINERO INGRESADO POR MES EN EL AÑO</h2>
                    <div id="ingresosAnio"></div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
