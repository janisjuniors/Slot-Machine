<?php

$wallet = 100;

$board = [
    [' ', ' ', ' ', ' ', ' '],
    [' ', ' ', ' ', ' ', ' '],
    [' ', ' ', ' ', ' ', ' ']
];

function displayBoard(array $board)
{
    echo "\t" . implode('  ', $board[0]) . PHP_EOL;
    echo "\t" . implode('  ', $board[1]) . PHP_EOL;
    echo "\t" . implode('  ', $board[2]) . PHP_EOL;
}

$symbols = [
    "\e[1;37;40mK\e[0m", "\e[1;33;40mA\e[0m", "\e[0;32;40mB\e[0m",
    "\e[0;34;40m*\e[0m", "\e[0;31;40m$\e[0m"
];

$multipliers = [1.2, 1.6 , 2, 2.5, 5];

echo 'Welcome to slots game!' . PHP_EOL;
echo PHP_EOL;
echo "Your balance is $wallet" . PHP_EOL;
$bet = (int)readline('Choose your bet size: ');
$choice = (string)readline('Spin? (Enter/any): ');


function checkingWinLines(array $timesChar, string $symbolString, int $bet, array $multipliers, array $symbols): float
{
    foreach ($timesChar as $char => $times) {
        if (strpos($symbolString, $char . $char . $char . $char . $char) !== false) {
            $keyForWinSymbol = array_search($char, $symbols);
            return $bet * $multipliers[$keyForWinSymbol] * 1.5;
        } elseif (strpos($symbolString, $char . $char . $char . $char) !== false) {
            $keyForWinSymbol = array_search($char, $symbols);
            return $bet * $multipliers[$keyForWinSymbol] * 1.4;
        } elseif (strpos($symbolString, $char . $char . $char) !== false) {
            $keyForWinSymbol = array_search($char, $symbols);
            return $bet * $multipliers[$keyForWinSymbol] * 1.3;
        }
    }
    return  0;
}

function swap(&$x, &$y) {
    $tmp = $x;
    $x = $y;
    $y = $tmp;
}

while (true) {
    for ($i = 0; $i < count($board); $i++) {
        for ($j = 0; $j < count($board[$i]); $j++) {
            $board[$i][$j] = $symbols[rand(0, count($symbols) - 1)];
        }
    }

    displayBoard($board);

    $moneyWonTotalSpin = 0;
    // Horizontal Lines
    for ($i = 0; $i < count($board); $i++) {
        $symbolString = implode('', $board[$i]);
        $timesChar = array_count_values($board[$i]);
        $moneyWonTotalSpin += checkingWinLines($timesChar, $symbolString, $bet, $multipliers, $symbols);
    }

    // 1st Diagonal
    $diagonal = [];
    $diagonalLineArr = array_merge(...$board);
    foreach ($diagonalLineArr as $key => $symbol) {
        if ($key === 0 || $key === 4 || $key === 8 || $key === 6 || $key === 12) {
            $diagonal[] = $symbol;
        }
    }
    swap($diagonal[1], $diagonal[2]);
    swap($diagonal[2], $diagonal[4]);

    $timesChar = array_count_values($diagonal);
    $diagonal = implode('', $diagonal);
    $moneyWonTotalSpin += checkingWinLines($timesChar, $diagonal, $bet, $multipliers, $symbols);


    // 2nd Diagonal
    $diagonal = [];
    $diagonalLineArr = array_merge(...$board);
    foreach ($diagonalLineArr as $key => $symbol) {
        if ($key === 2 || $key === 6 || $key === 8 || $key === 10 || $key === 14) {
            $diagonal[] = $symbol;
        }
    }
    swap($diagonal[0], $diagonal[3]);
    swap($diagonal[2], $diagonal[3]);

    $timesChar = array_count_values($diagonal);
    $diagonal = implode('', $diagonal);
    $moneyWonTotalSpin += checkingWinLines($timesChar, $diagonal, $bet, $multipliers, $symbols);

    if ($moneyWonTotalSpin == 0) {
        $wallet -= $bet;
        echo 'You lost!' . PHP_EOL;
    } else {
        $wallet += $moneyWonTotalSpin;
        echo 'Money won: ' . $moneyWonTotalSpin . PHP_EOL;
    }
    echo 'Your balance: ' . $wallet . PHP_EOL;

    $choice = (string)readline('Spin? (Enter/any): ');
    if (strlen($choice) === 0)  {
        continue;
    } else {
        exit;
    }
}


