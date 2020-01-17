<input type="text" class="form-control form-control-sm m-b-xs" id="filter"
    placeholder="Search in table">

<table class="footable table table-stripped" data-page-size="8" data-filter=#filter>
    <thead>
        <tr>
            <th>姓名</th>
            <th>Email</th>
            <th>身份</th>
            <th data-hide="phone,tablet">帳號狀態</th>
            <th data-hide="phone,tablet">擁有權限</th>
            <th data-hide="phone,tablet">備註</th>
        </tr>
    </thead>
    <tbody>
    <?php
        require_once('../db.inc.php');
        $sql = "";
    ?>
        <tr class="gradeX">
            <td>Trident</td>
            <td>Internet
                Explorer 4.0
            </td>
            <td>Win 95+</td>
            <td class="center">4</td>
            <td class="center">X</td>
        </tr>
        <tr class="gradeC">
            <td>Trident</td>
            <td>Internet
                Explorer 5.0
            </td>
            <td>Win 95+</td>
            <td class="center">5</td>
            <td class="center">C</td>
        </tr>
        <tr class="gradeA">
            <td>Trident</td>
            <td>Internet
                Explorer 5.5
            </td>
            <td>Win 95+</td>
            <td class="center">5.5</td>
            <td class="center">A</td>
        </tr>
        <tr class="gradeA">
            <td>Gecko</td>
            <td>Netscape Navigator 9</td>
            <td>Win 98+ / OSX.2+</td>
            <td class="center">1.8</td>
            <td class="center">A</td>
        </tr>

        <tr class="gradeA">
            <td>Webkit</td>
            <td>Safari 1.3</td>
            <td>OSX.3</td>
            <td class="center">312.8</td>
            <td class="center">A</td>
        </tr>
        <tr class="gradeA">
            <td>Webkit</td>
            <td>Safari 2.0</td>
            <td>OSX.4+</td>
            <td class="center">419.3</td>
            <td class="center">A</td>
        </tr>
        <tr class="gradeA">
            <td>Webkit</td>
            <td>Safari 3.0</td>
            <td>OSX.4+</td>
            <td class="center">522.1</td>
            <td class="center">A</td>
        </tr>
        <tr class="gradeA">
            <td>Webkit</td>
            <td>OmniWeb 5.5</td>
            <td>OSX.4+</td>
            <td class="center">420</td>
            <td class="center">A</td>
        </tr>
        <tr class="gradeA">
            <td>Webkit</td>
            <td>iPod Touch / iPhone</td>
            <td>iPod</td>
            <td class="center">420.1</td>
            <td class="center">A</td>
        </tr>
        <tr class="gradeA">
            <td>Webkit</td>
            <td>S60</td>
            <td>S60</td>
            <td class="center">413</td>
            <td class="center">A</td>
        </tr>
        <tr class="gradeA">
            <td>Presto</td>
            <td>Opera 7.0</td>
            <td>Win 95+ / OSX.1+</td>
            <td class="center">-</td>
            <td class="center">A</td>
        </tr>
        <tr class="gradeA">
            <td>Presto</td>
            <td>Opera 7.5</td>
            <td>Win 95+ / OSX.2+</td>
            <td class="center">-</td>
            <td class="center">A</td>
        </tr>
        <tr class="gradeA">
            <td>Presto</td>
            <td>Opera 8.0</td>
            <td>Win 95+ / OSX.2+</td>
            <td class="center">-</td>
            <td class="center">A</td>
        </tr>
    </tbody>
    <tfoot>
        <tr>
            <td colspan="5">
                <ul class="pagination float-right"></ul>
            </td>
        </tr>
    </tfoot>
</table>
