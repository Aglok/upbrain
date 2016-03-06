$(function () {
    /* Установка jquery-ajax запроса с csrf-token
       Берём значение token из скрытового input
       Отправляем с заголовком
    */
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('input[name="csrf-token"]').attr('content')
        }
    });

    /*
    * Убираем начальный выбор select и заменяем на свой текст.
    * @var object
    * */
    function removeSelected(elBtn){
        $(elBtn).each(function(){
            $(this).attr('title', 'Ничего не выбрано').html('Ничего не выбрано <b class="caret"></b>');
        });

        var elUl = $(elBtn).next();
        var radioBtn = elUl.find('li.active input');
        radioBtn.each(function(){
            $(this).attr('checked',false).closest('li').removeClass('active');
        });
    }


    /*
    * Функция выводит текст в option
    * @var Object
    * @return string
    * */
    function textArgument(obj){
        var arg = '';
        if(obj[1] == 'surname') arg = this[obj[1]]+' '+this[obj[0]];
        else{
            for (var i = 0; i < obj.length; i++){
                if(i == obj.length-1)
                    arg += '('+this[obj[i]]+')';
                else
                    arg += this[obj[i]]+' ';
            }
        }
        return arg;
    }

    /*
     * Функция создает ajax запрос и получает значение с сервера
     * @var string
     * @var string
     * @var string
     * */

    function ajaxSelect(url, selectedParam) {

        $.ajax({
            type: 'POST',
            url: url,
            data: {id: selectedParam}
        }).done(function (data) {
            //data - объект модели
            //Удаление лишних элементов, после создания списка для другой группы
            var model = data[0];
            var param = data[1];

            if(param == 'progress'){
                var label = $('label[for=exp_progress]');
                if(label) label.remove();

                var strInput = '<label for="exp_progress">' + model[0].name + ' <input type="text" name="exp_progress" value="10"></label>';
                $('#select').append(strInput);
                return false;
            }

            //Выбрать элемент с указанным id
            var elSelect = $('select' + '#' + param.idNameSelect);

            if ($('select').is('#' + param.idNameSelect)) {
                elSelect.nextAll().remove();//<div class="btn-group>...</div> удаляет все элементы после указанного elSelect
                elSelect.remove();//<select id='users'>...</select>
            }
            var select = $('<select/>', {
                id: param.idNameSelect,
                name: param.idNameSelect,
                class: 'multiselect form-control',
                'data-select-type': 'single'
            });

            //Наполняем список options
            $.each(model, function () {
                $('<option/>', {
                    val: this.id,
                    text: textArgument.bind(this, param.prop)
                }).appendTo(select);
            });

            $('#select').append(select);

            //Меняем вид списка на dropdown radio
            $('.multiselect'+'#'+param.idNameSelect).multiselect({buttonClass: param.idNameSelect + ' btn btn-default'});
            //Удаляем лишний select после выбора

            refreshSelects(param.url, param.idNameSelect);
            removeSelected('.'+param.idNameSelect);

        });
    }

    /*
     * Функция инициализирует выбор из списка и запускает ajax зарос
     * @var string
     * @var string
     * */
    function refreshSelects(url, elClass){
        var el = $('.'+elClass).next().find('li input');

        // Ждем изменений
        $(el).change(function(){

            // Выбранная опция
            var id = $(this).val();
            //Запускаем запрос ajax и строим select
            ajaxSelect(url , id);

        });
    }

    removeSelected('button.multiselect');
    refreshSelects('group','multiselect');


    //Начинаем путь перехода на плагин dataTable
    //console.log(table.column(3).data().sum());
    var data = {};
    var array = [];//вспомогательный массив для преобразования в json и отправки на сервер

    $('button.btn-primary').on('click', function(){

        var user = {};//объект будет содержать информацию о учениках
        var input = $('#select li.active input[type=radio]');
        var nameAttr = $('#select li.active').closest('div.btn-group').prev();
        var num_lesson = $('input[name=number_lesson]');
        var exp_progress = $('input[name=exp_progress]');

        //Если чекбоксы выбраны -> берём все данные из ячеек строки
        $('input:checkbox:checked').closest('tr').each(function(j, tr){

            var task = {};//объект будет содержать информацию о задачах

            for(var i=0; i<tr.children.length; i++){

                var input = tr.children[i].firstElementChild;
                var attr = input.getAttribute('name');
                task[attr] = input.value;
            }
            array[j] = task;//Записываем объект в массив
        });

        //Проверяем выбраны ли задачи!
        if(!array.length){
            console.log('Выберите задачи');
            return false;
        }
        //Добавляем строку и подсчитываем сумму очков и золота по grade и subject
        buildHtml();

        //Если select выбраны -> берём данные
        for(var i=0; i < input.length; i++){
            var name = nameAttr[i].getAttribute('name');
            var value = input[i].value;
            user[name] = value;
        }

        user[num_lesson.attr('name')] = num_lesson.val();
        user[exp_progress.attr('name')] = exp_progress.val();

        data.task = array;
        data.user = user;

        //Проверка на выбранные списки
        if(!validateSelect(user)) return;

        //Преобразование в json
        var json = JSON.stringify(data);
        console.log(json);

        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: 'save',
            data: {json}
        }).done(function (data) {
            console.log(data);
        });
    });
    //Функция считает сумму значений столбцов по experience и gold
    function sumParamHtml(arr, text, bool, subject){
        var sumExp = 0;//сумма золота
        var sumGold = 0;//сумма опыта
        var count = arr.length;//количество решённых задач

        for(var i=0; i<count; i++){
            sumExp += parseInt(arr[i].experience);
            sumGold += parseInt(arr[i].gold);
            if(bool)
                subject.push(arr[i].subject_id);
        }
        if(!bool){
            //Для вывода уникального значения кода предмета из данных
            var re = /[^.](\d)$|(\d(?:\.\d){0,5})/i;
            var subject_id = text.match(re);

            //Создаём объекты данных для передачи на сервер
            if(/D/.test(text)){
                var grade_D = new Grade('D',sumExp, sumGold, count, subject_id[1]);
                data.D.push(grade_D);
            }else if(/C/.test(text)){
                var grade_C = new Grade('C',sumExp, sumGold, count, subject_id[1]);
                data.C.push(grade_C);
            }else if(/B/.test(text)){
                var grade_B = new Grade('B',sumExp, sumGold, count, subject_id[1]);
                data.B.push(grade_B);
            }else if(/A/.test(text)){
                var grade_A = new Grade('A',sumExp, sumGold, count, subject_id[1]);
                data.A.push(grade_A);
            }
        }
        var str = '\<tr><td colspan="6">'+ text +'\</td><td>Суммарный опыт:' + sumExp +'\</td>'
                         + '\<td>Суммарно монет:' + sumGold +'\</td>'
                         + '\<td>Решённых задач:' + count +'\</td>' +
                    '\<\tr>';

        $('table.table tbody').append(str);
    }
    //Функция делает html пристройку к таблице
    //для вывода суммы значений
    //по фильтру данных(grade и subject_id)
    function buildHtml(){
        var newArray = array.slice();
        var subject = [];
        data.D = [];//массивы для хранения данных суммы опыта и монет
        data.C = [];
        data.B = [];
        data.A = [];

        sumParamHtml(newArray, 'Всего', true, subject);

        var uniqueSubject = uniqueArray(subject);

        for(i=0; i<uniqueSubject.length; i++){

            var arr = filterArray(newArray, 'subject_id', uniqueSubject[i]);

            var D = filterArray(arr,'grade','D');
            var C = filterArray(arr,'grade','C');
            var B = filterArray(arr,'grade','B');
            var A = filterArray(arr,'grade','A');

            (D.length) ? sumParamHtml(D, 'D grade '+'раздел № '+uniqueSubject[i], false):false;
            (C.length) ? sumParamHtml(C, 'C grade '+'раздел № '+uniqueSubject[i], false):false;
            (B.length) ? sumParamHtml(B, 'B grade '+'раздел № '+uniqueSubject[i], false):false;
            (A.length) ? sumParamHtml(A, 'A grade '+'раздел № '+uniqueSubject[i], false):false;
        }

    }

    //Вспомогательная функция создаёт объект для сохранения данных о суммарных данных
    function Grade(grade, sumExp, sumGold, count, subject_id){
        this.grade = grade;
        this.sumExp = sumExp;
        this.sumGold = sumGold;
        this.sumTask = count;
        this.subject_id = subject_id;
    }

    //Вспомогательная функция выбирает уникальные значения массива
    function uniqueArray(array){
        var j = array.length;

        array.sort(function(a,b){
            return a-b;
        });

        while(j--){
            if(array[j] == array[j-1])
                array.splice(j, 1);
        }
        return array;
    }
    //Вспомогательная функция фильтрует массив по значению объекта
    function filterArray(array, name, prop){
        return array.filter(function(num){
            return num[name] == prop;
        });
    }
    //Валидация данных на выбранные обязательные списки
    function validateSelect(obj){
        var names = {'group': true, 'users': true, 'stages': true, 'user_progress': true, 'number_lesson':true};
        var str = '';
        for(var key in names){
            if(!obj[key])
                str += key + ' ';
        }
        if(str.length) {
            console.log('Пожалуйста выберите следующие поля: '+ str);
            return false;
        }
        else {
            console.log('Данные успешно отправлены!');
            return true;
        }
    }
});

