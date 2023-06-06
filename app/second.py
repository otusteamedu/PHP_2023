from itertools import product

def letterCombinations(digits):
    if not digits:
        return []

    mapping = {'2': 'abc', '3': 'def', '4': 'ghi', '5': 'jkl', '6': 'mno', '7': 'pqrs', '8': 'tuv', '9': 'wxyz'}

    groups = (mapping[digit] for digit in digits)

    return [''.join(combination) for combination in product(*groups)]

print(letterCombinations("23"))
