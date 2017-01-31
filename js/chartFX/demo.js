function demo() {
	demo1();
	demo2();
	demo3();
	demo4();	
}


function demo1(painterType) {
	var c = new Chart(document.getElementById('chart'));
	if (painterType == 'svg') { c.setPainterFactory(SVGChartPainterFactory); }
	c.setDefaultType(CHART_AREA | CHART_STACKED);
	c.setGridDensity(10, 10);
	c.setVerticalRange(-100, 300);
	c.setHorizontalLabels(['mon', 'tue', 'wed', 'thu', 'fri', 'sat', 'sun', 'mon', 'tue', 'wed']);
	c.setBarWidth(10);
	c.add('Spam',            '#4040FF', [ 5,  10,  20,  10,  40,  52,  68,  70,  70,  60]);
	c.add('Innocent',        '#8080FF', [ 8,   7,  12,  20,  24,  16,  36,  28,  28,  45]);
	c.add('Missed Spam',     '#A5A5FF', [ 8,   7,  12,  20,  24,  16,  36,  36,  18,   5]);
	c.add('False Positives', '#DEDEFF', [ 1, -20,   3,   2,   1,   4, -80,  12,   8, -10]);
	c.add('SMTP Rejects',    'red',     [45,  54,  65, 150, 280, 120,  86,  65,  74,  12], CHART_LINE);
	c.add('System Load',     '#008800', [-8,  -7, -12, -20, -24, -16, -36, -36, -18],      CHART_BAR);
	c.add('Memory Usage',    '#009900', [-1, -20,  -3,  -2,  -1,  -4, -80, -12,  -8],      CHART_BAR);
	c.draw();
}

function demo2() {
	var c = new Chart(document.getElementById('chart2'));
	c.setDefaultType(CHART_AREA | CHART_STACKED);
	c.setGridDensity(5, 5);
	c.setVerticalRange(-100, 300);
	c.setHorizontalLabels(['mon', 'tue', 'wed', 'thu', 'fri', 'sat', 'sun', 'mon', 'tue', 'wed']);
	c.add('Spam',            '#4040FF', [ 5,  10,  20,  10,  40,  52,  68,  70,  70,  60]);
	c.add('Innocent',        '#8080FF', [ 8,   7,  12,  20,  24,  16,  36,  28,  28,  45]);
	c.add('Missed Spam',     '#A5A5FF', [ 8,   7,  12,  20,  24,  16,  36,  36,  18,   5]);
	c.add('False Positives', '#DEDEFF', [ 1, -20,   3,   2,   1,   4, -80,  12,   8, -10]);
	c.add('SMTP Rejects',    'red',     [45,  54,  65, 150, 280, 120,  86,  65,  74,  12], CHART_LINE);
	c.draw();
}

function demo3() {
	var c = new Chart(document.getElementById('chart3'));
	c.setDefaultType(CHART_LINE);
	c.setGridDensity(10, 10);
	c.setHorizontalLabels(['mon', 'tue', 'wed', 'thu', 'fri', 'sat', 'sun', 'mon', 'tue', 'wed']);
	c.setShowLegend(false);
	c.add('', '#4040FF', [ 5, 10, 20, 10, 40, 52, 68, 70, 70, 60]);
	c.add('', '#8080FF', [ 8,  7, 12, 20, 24, 16, 36, 28, 28, 45]);
	c.add('', '#FF8080', [ 3, 12,  5, 18, 20, 13, 28, 36, 18,  5]);
	c.add('', '#FF00FF', [ 1, 20,  3,  2,  1,  4, 10, 12,  8, 10]);
	c.draw();
}

function demo4() {
	var c = new Chart(document.getElementById('chart4'));
	c.setDefaultType(CHART_BAR);
	c.setGridDensity(0, 0);
	c.setBarWidth(10);
	c.setBarDistance(1);
	c.setShowLegend(false);
	c.add('', 'blue',  [6, 3, 9, 6, 1, 3]);
	c.add('', 'red',   [7, 1, 2, 9, 3, 6]);
	c.add('', 'green', [2, 7, 1, 3, 7, 2]);
	c.draw();
}