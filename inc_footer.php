</td></tr>
<tr><td colspan="2" align="center" height="20" bgcolor="#11161f">
 <!-- parameter untuk kawal saiz -->
 Saiz Teks: <br><a class='button' href='?font=plus'>+</a>
 <a class='button' href='?font=minus'>-</a>
 <a class='button' href='?font=reset'>Reset</a>
 <br><br>
 <a href='javascript:void(0);' onclick='window.print()'>Cetak Halaman</a> -
 <a href='javascript:void(0);' onclick='printcontent("printcontent")'>Cetak
Kandungan</a>
 <br>
 Copyright @ Portal KHD-AN</td></tr>
</table>
<script type="text/javascript">
// skrip untuk cetak bahagian khas kandungan sahaja
function printcontent(areaID){
    var printContent = document.getElementById(areaID);
    var WinPrint = window.open('', '', 'width=900,height=650');
    WinPrint.document.write(printContent.innerHTML);
    WinPrint.document.close();
    WinPrint.focus(); WinPrint.print(); WinPrint.close();
}
</script>
</body>
<html>