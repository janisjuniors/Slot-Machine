<?php

$wallet = 100;

$board = [
    [' ', ' ', ' ', ' ', ' '],

    [' ', ' ', ' ', ' ', ' '],

    [' ', ' ', ' ', ' ', ' ']
];

function checkFreeSpaces(array $board): int
{
    $freeSpaces = 15;

    for ($i = 0; $i < 3; $i++){
        for ($j = 0; $j < 5; $j++){
            if ($board[$i][$j] != ' '){
                $freeSpaces--;
            }
        }
    }

    return $freeSpaces;
}

function displayBoard(array $board)
{
    echo "\t" . implode('  ', $board[0]) . PHP_EOL;
    echo "\t" . implode('  ', $board[1]) . PHP_EOL;
    echo "\t" . implode('  ', $board[2]) . PHP_EOL;
}

$symbols = ['F','K', 'A', 'W', 'B', 'Q', '*'];
$multipliers = [0.5, 1.5, 2, 3, 4, 5, 50];
$winningSymbol = ' ';

function winLine($board, $winningSymbol)
{
    for ($i = 0; $i < 3; $i++) {
        // ALL HORIZONTAL SYMBOLS THE SAME
        if ($board[$i][0] === $board[$i][1]
            && $board[$i][0] === $board[$i][2]
            && $board[$i][0] === $board[$i][3]
            && $board[$i][0] === $board[$i][4]) {
            return $board[$i][0];
        }
        // 4 HORIZONTAL SYMBOLS THE SAME FROM 0
        if ($board[$i][0] === $board[$i][1]
            && $board[$i][1] === $board[$i][2]
            && $board[$i][2] === $board[$i][3]) {
            return $board[$i][0];
        }
        // 4 HORIZONTAL SYMBOLS THE SAME FROM 1
        if ($board[$i][1] === $board[$i][2]
            && $board[$i][2] === $board[$i][3]
            && $board[$i][3] === $board[$i][4]) {
            return $board[$i][1];
        }
        // 3 HORIZONTAL SYMBOLS THE SAME FROM 0
        if ($board[$i][0] === $board[$i][1]
            && $board[$i][1] === $board[$i][2]) {
            return $board[$i][0];
        }
        // 3 HORIZONTAL SYMBOLS THE SAME FROM 1
        if ($board[$i][1] === $board[$i][2]
            && $board[$i][2] === $board[$i][3]) {
            return $board[$i][1];
        }
        // 3 HORIZONTAL SYMBOLS THE SAME FROM 2
        if ($board[$i][2] === $board[$i][3]
            && $board[$i][3] === $board[$i][4]) {
            return $board[$i][2];
        }
        // 1ST ZIGZAG PAY LINE SYMBOLS THE SAME
        if ($board[0][0] === $board[1][1]
            && $board[1][1] === $board[2][2]
            && $board[2][2] === $board[1][3]
            && $board[1][3] === $board[0][4]) {
            return $board[0][0];
        }
        // 1ST ZIGZAG PAY LINE 4 SYMBOLS THE SAME
        if ($board[0][0] === $board[1][1]
            && $board[1][1] === $board[2][2]
            && $board[2][2] === $board[1][3]) {
            return $board[0][0];
        }
        // 1ST ZIGZAG PAY LINE LAST 4 SYMBOLS THE SAME
        if ($board[1][1] === $board[2][2]
            && $board[2][2] === $board[1][3]
            && $board[1][3] === $board[0][4]) {
            return $board[1][1];
        }

        // 1ST ZIGZAG PAY LINE LAST 3 SYMBOLS THE SAME
        if ($board[0][0] === $board[1][1]
            && $board[1][1] === $board[2][2]) {
            return $board[0][0];
        }

        // 1ST ZIGZAG PAY LINE LAST 2ND 3 SYMBOLS THE SAME
        if ($board[1][1] === $board[2][2]
            && $board[2][2] === $board[1][3]) {
            return $board[1][1];
        }

        // 1ST ZIGZAG PAY LINE LAST 3RD 3 SYMBOLS THE SAME
        if ($board[2][2] === $board[1][3]
            && $board[1][3] === $board[0][4]) {
            return $board[2][2];
        }

        // 2ND ZIGZAG PAY LINE SYMBOLS THE SAME
        if ($board[2][0] === $board[1][1]
            && $board[1][1] === $board[0][2]
            && $board[0][2] === $board[1][3]
            && $board[1][3] === $board[2][4]) {
            return $board[2][0];
        }

        // 2ND ZIGZAG PAY LINE 4 SYMBOLS THE SAME
        if ($board[2][0] === $board[1][1]
            && $board[1][1] === $board[0][2]
            && $board[0][2] === $board[1][3]) {
            return $board[2][0];
        }

        // 2ND ZIGZAG PAY LINE 4 SYMBOLS THE SAME
        if ($board[1][1] === $board[0][2]
            && $board[0][2] === $board[1][3]
            && $board[1][3] === $board[2][4]) {
            return $board[1][1];
        }

        // 2ND ZIGZAG PAY LINE 3 SYMBOLS THE SAME
        if ($board[2][0] === $board[1][1]
            && $board[1][1] === $board[0][2]) {
            return $board[2][0];
        }

        // 2ND ZIGZAG PAY LINE 2ND 3 SYMBOLS THE SAME
        if ($board[1][1] === $board[0][2]
            && $board[0][2] === $board[1][3]) {
            return $board[1][1];
        }

        // 2ND ZIGZAG PAY LINE 3RD 3 SYMBOLS THE SAME
        if ($board[0][2] === $board[1][3]
            && $board[1][3] === $board[2][4]) {
            return $board[0][2];
        }
    }

    return $winningSymbol;
}

echo 'Welcome to slots game!' . PHP_EOL;
echo PHP_EOL;
echo "Your balance is $wallet" . PHP_EOL;
$bet = (int)readline('Choose your bet size: ');
$choice = (string)readline('Spin? (Y/N): ');

while (true) {
    while (checkFreeSpaces($board) > 0) {
        for ($i = 0; $i < 3; $i++) {
            for ($j = 0; $j < 5; $j++) {
                $randomChar = $symbols[array_rand($symbols)];
                $board[$i][$j] = $randomChar;
            }
        }
        displayBoard($board);


        if (winLine($board, $winningSymbol) != ' '){
            $keyForWinSymbol = array_search(winLine($board,$winningSymbol), $symbols);
            $multiplier = $multipliers[$keyForWinSymbol];
            $winningSum = $bet * $multiplier;
            echo 'Multiplier you got is ' . $multiplier . PHP_EOL;
            echo 'You won ' . $winningSum . PHP_EOL;
            $wallet += $winningSum;
        } else {
            echo 'You lost this time!' . PHP_EOL;
            $wallet -= $bet;
            if ($wallet <= 0) {
                echo 'You dont have any more money!' . PHP_EOL;
                exit;
            } elseif ($wallet < $bet){
                echo 'You dont have enough money!' . PHP_EOL;
                exit;
            }
        }
        echo "Your balance is $wallet" . PHP_EOL;

        $choice = (string)readline('Spin? (Y/N): ');

        if ($choice === 'Y') {
            for ($i = 0; $i < 3; $i++) {
                for ($j = 0; $j < 5; $j++) {
                    $board[$i][$j] = ' ';
                }
            }
        } else {
            exit;
        }


    }
}

