<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Course Name</title>
    <!-- Quicksand -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300..700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="styles/InsideCoursestyle.css" />
  </head>
  <body>
    <header>
      <div class="container">
        <div class="rectangle">
          <div class="circle"></div>
          <p class="nama">username</p>
          <nav>
            <div class="navigation">
              <a href="home.php">home</a>
              <a href="course.php" class="underline">course</a>
              <a href="#forum">forum</a>
            </div>
          </nav>
        </div>
      </div>
    </header>
    <main>
      <h1 style="margin: 20px">COURSE 1</h1>
      <div class="container-namapengajar">
        <div class="circle"></div>
        <h2>nama pengajar</h2>
      </div>
      <div class="container-main">
        <div class="container-materi">
          <img src="../images/business.jpg" class="gambarKurs">
          <h1 class="judul">PDF</h1>
          <div class="container-linktabel">
              <form>
                <button class="rectangle-3" type="submit" id="download-pdf">Download</button>
              </form>
          </div>
        </div>
        <div class="container-materi">
          <img src="../images/business.jpg" class="gambarKurs">
          <h1 class="judul">Video</h1>
          <div class="container-linktabel">
              <form>
                <button class="rectangle-3" type="submit" id="download-video">Download</button>
              </form>
          </div>
        </div>
        <div class="container-materi">
          <img src="../images/business.jpg" class="gambarKurs">
          <h1 class="judul">Quiz</h1>
          <div class="container-linktabel">
              <form>
                <button class="rectangle-3" type="submit" id="do_now">Do Now</button>
              </form>
          </div>
        </div>
        <div class="container-materi">
          <img src="../images/business.jpg" class="gambarKurs">
          <h1 class="judul">Assignment</h1>
          <div class="container-linktabel">
              <form>
                <button class="rectangle-3" type="submit" id="submit">Submit</button>
              </form>
          </div>
        </div>
      </div>
    </main>
  </body>
</html>
