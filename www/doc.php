<?php include("header.php"); ?>

<style type="text/css">
	pre {
	    background-color: #dedada;
	    padding: 10px;
	}
</style>


<div style="font-size: 16px; font-family: sans-serif;">
	<h2 style="text-align: center;margin: 10px;">Hướng dẫn làm và nộp bài</h2>

	<div style="float:right;">
		<ul>
			<li><a href="#1">1. Xem đề bài</a></li>
			<li><a href="#2">2. Cách đặt tên file mã nguồn</a></li>
			<li><a href="#3">3. Nộp bài</a></li>
			<li><a href="#4">4. Cách viết code</a></li>
			<li><a href="#5">5. Cách nhập xuất ra file</a></li>
		</ul>
	</div>

	<a name="1"><h3>1. Xem đề bài</h3></a>
	Click vào tên bài ở bảng điểm để xem đề bài
	<a name="2"><h3>2. Cách đặt tên file mã nguồn</h3></a>
	Tên file phải đặt đúng theo yêu cầu đề bài kèm theo phần mở rộng của file. <br>
	Ví dụ yêu cầu đề bài là TONG.*** thì tên file là TONG.c (ngôn ngữ C) hoặc TONG.cpp (ngôn ngữ C++) hoặc TONG.java (ngôn ngữ java).
	<a name="3"><h3>3. Nộp bài</h3></a>
	Click chọn file cần nộp rồi click nút <strong>Nộp</strong>. Sau khi nộp bài, đợi khoảng 5 giây và load lại trang để xem điểm của mình.
	<a name="4"><h3>4. Cách viết code</h3></a>
	<ul>
		<li>Không dùng lệnh in ra màn hình những gì không cần thiết, chỉ in ra kết quả theo đúng định dạng yêu cầu đề bài</li>
		<li>không sử dụng thư viện conio.h với C/ C++</li>
		<li>Code không có lệnh dừng màn hình: getch(); system("pause") </li>
		<li>Với ngôn ngữ C, C++, hàm main viết là <strong>int main</strong>, cuối hàm main cần có lệnh <strong>return 0;</strong></li>
	</ul>

	<strong>Ví dụ đề bài:</strong>
	Cho số nguyên n, Kiểm tra số n là chẵn hay lẻ, nếu là chẵn in ra <strong>chan</strong>, nếu là lẻ in ra <strong>le</strong> <br>
	<strong>Đầu vào:</strong> Một số nguyên duy nhất n. <br>
	<strong>Đầu ra:</strong> Một từ duy nhất là <strong>chan</strong> nếu n chẵn, <strong>le</strong> nếu n lẻ. <br>

	<strong>Code sai:</strong>
	<pre>
	#include &lt;stdio.h&gt;

	void main()				// sai
	{
		int n;
		printf("Nhap n = ");		// sai
		scanf("%d", &amp;n);

		if(n % 2 == 0){
			printf("n la so chan");	// sai
		}else{
			printf("n la so le");	// sai
		}
		// thieu return 0;
	}
	</pre>
	<strong>Code đúng:</strong>
	<pre>
	#include &lt;stdio.h&gt;

	int main()
	{
		int n;
		scanf("%d", &amp;n);
		if(n % 2 == 0){
			printf("chan");
		}else{
			printf("le");
		}

		return 0;
	}
	</pre>

	<a name="5"><h3>5. Cách nhập xuất file</h3></a>

	Thông thường các bài đều yêu cầu nhập và xuất file vì vậy đây là kiến thức cần thiết. Dưới đây là cách đọc 1 số từ file TEST.INP sau đó ghi số đó ra file TEST.OUT một cách đơn giản với các ngôn ngữ. <br>
	Lưu ý file <strong>TEST.INP và TEST.OUT nằm cùng thư mục với file mã nguồn</strong> khi dùng C hoặc C++. <br>
	Với Java, các file TEST.INP và TEST.OUT nằm ở thư mục chứa project (ngang hàng với thư mục <strong>src</strong>) <br>

	<h4>Ngôn ngữ C</h4>

	<pre>
	#include &lt;stdio.h&gt;

	int main()
	{
		int n;
		FILE *fi = fopen("TEST.INP", "r");		// mo file de doc
		fscanf(fi, "%d", &n);				// doc n tu file fi
		fclose(fi);

		FILE *fo = fopen("TEST.OUT", "w");		// mo file de ghi
		fprintf(fo, "%d", n);				// ghi n ra file fo
		fclose(fo);

		return 0;
	}
	</pre>

	<h4>Ngôn ngữ C++</h4>

	<pre>
	#include &lt;fstream&gt;
	using namespace std;

	int main()
	{
		int n;
		ifstream fi("TEST.INP"); 	// mo file de doc
		fi >> n;

		ofstream fo("TEST.OUT"); 	// mo file de ghi
		fo << n;

		return 0;
	}
	</pre>

	<h4>Ngôn ngữ Java</h4>

	<pre>
	package test;
	import java.io.File;
	import java.io.FileNotFoundException;
	import java.io.PrintWriter;
	import java.util.Scanner;

	public class Test {
		public static void main(String[] args) throws FileNotFoundException {
			Scanner scan = new Scanner(new File("TEST.INP"));
			int n = scan.nextInt();
			scan.close();
			
			PrintWriter pr = new PrintWriter(new File("TEST.OUT"));
			pr.print(n);
			pr.close();
		}
	}
	</pre>
</div>




	</div>  <!-- end container -->
</div> <!-- end jumbotron -->
<?php include("footer.php"); ?>