import './bootstrap';

import Alpine from 'alpinejs';
import Swal from 'sweetalert2'
import toastr from 'toastr'
import flatpickr from 'flatpickr';

window.Alpine = Alpine;
window.Swal = Swal;
window.toastr = toastr;

Alpine.start();

flatpickr('.datepicker', {
    dateFormat: 'd-m-Y',
    prevArrow: '<svg class="fill-current" width="7" height="11" viewBox="0 0 7 11"><path d="M5.4 10.8l1.4-1.4-4-4 4-4L5.4 0 0 5.4z" /></svg>',
    nextArrow: '<svg class="fill-current" width="7" height="11" viewBox="0 0 7 11"><path d="M1.4 10.8L0 9.4l4-4-4-4L1.4 0l5.4 5.4z" /></svg>',
});

const get_month = (value) => {
    const nombreMes = {
        'January': 'Enero',
        'February': 'Febrero',
        'March': 'Marzo',
        'April': 'Abril',
        'May': 'Mayo',
        'June': 'Junio',
        'July': 'Julio',
        'August': 'Agosto',
        'September': 'Septiembre',
        'October': 'Octubre',
        'November': 'Noviembre',
        'December': 'Diciembre'
    }
    return nombreMes[value];
}

const get_day = value => {
    const nombreDia = {
        'Monday':  'Lunes',
        'Tuesday': 'Martes',
        'Wednesday': 'Miercoles',
        'Thursday': 'Jueves',
        'Friday': 'Viernes',
        'Saturday': 'Sabado',
        'Sunday': 'Domingo'
    }
    return nombreDia[value]
}

const fecha_inicio = document.querySelector('#fecha_inicio'),
    fecha_fin = document.querySelector('#fecha_fin'),
    btnBuscar = document.querySelector('#btnBuscar'),
    btnLimpiar = document.querySelector('#btnLimpiar');

    const peticion_ingresos_mes = async (fecha_inicio = '', fecha_fin = '') => {
        try {
            const response = await axios.post('/ingresos-mes', { fecha_inicio, fecha_fin });
            if(response.data.length > 0){
                let mes = response.data.map(item => {
                    if(fecha_inicio == "" && fecha_fin == ""){
                        return get_day(item.mes.substring(3, item.mes.length)) + ' - ' + item.mes.substring(0,2)
                    }else{
                        return item.mes;
                    }
                });
                let total = response.data.map(item => item.total);
                    var options = {
                        chart: {
                            "height": 300,
                            "type": 'line',
                        },
                        series: [{
                            name: 'Ingreso del Mes en Bs',
                            data: total
                        }],
                        xaxis: {
                            categories: mes
                        },
                        dataLabels: {
                            enabled: false
                        },
                        markers: {
                            size: 6
                        },
                        fill: {
                            type: 'gradient',
                        }
                    }
                var chart = new ApexCharts(document.querySelector("#ingresosMes"), options);
                chart.render();
            }
        } catch (error) {
            console.log(error)
        }
    }

    const peticion_ingresos_anio = async() => {
        try {
            const response = await axios.post('ingresos-anio')
            if(response.data.length > 0){
                let mes = response.data.map(item => get_month(item.mes));
                let total = response.data.map(item => item.total);
                var options = {
                    chart: {
                        height: 300,
                        type: 'bar',
                    },
                    series: [{
                        name: 'Total Ingreso Bs',
                        data: total
                    }],
                    xaxis: {
                        categories: mes
                    },
                    dataLabels: {
                        enabled: false
                    },
                    plotOptions: {
                        bar: {
                            distributed: true
                        }
                    },
                }
                const chartDia = new ApexCharts(document.querySelector("#ingresosAnio"), options);
                chartDia.render();
            }
        } catch (error) {
            console.log(error)
        }
    }

    peticion_ingresos_mes();
    peticion_ingresos_anio();

    if(btnBuscar){
        btnBuscar.addEventListener('click', e => {
            e.preventDefault();
            peticion_ingresos_mes(fecha_inicio.value, fecha_fin.value);
        });
    }

    if(btnLimpiar){
        btnLimpiar.addEventListener('click', e => {
            e.preventDefault();
            fecha_inicio.value = '';
            fecha_fin.value = '';
            peticion_ingresos_mes();
        });
    }
