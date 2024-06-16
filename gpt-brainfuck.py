import sys
import time

def execute_brainfuck(file_path: str) -> None:
    start_time = time.time()

    # Lire le fichier
    try:
        with open(file_path, 'r') as f:
            code = f.read()
    except IOError:
        print("Erreur de lecture du fichier.")
        return

    # Initialiser la mémoire et les pointeurs
    memory = [0] * 30000
    pointer = 0
    code_length = len(code)
    code_pointer = 0

    # Préparer une pile pour gérer les crochets
    bracket_stack = []

    # Prétraiter les boucles pour éviter des recherches répétées
    loop_map = {}
    stack = []
    for i, command in enumerate(code):
        if command == '[':
            stack.append(i)
        elif command == ']':
            start = stack.pop()
            loop_map[start] = i
            loop_map[i] = start

    # Traiter chaque caractère du code
    while code_pointer < code_length:
        command = code[code_pointer]
        if command == '>':
            pointer = (pointer + 1) % 30000
        elif command == '<':
            pointer = (pointer - 1 + 30000) % 30000
        elif command == '+':
            memory[pointer] = (memory[pointer] + 1) % 256
        elif command == '-':
            memory[pointer] = (memory[pointer] - 1 + 256) % 256
        elif command == '.':
            print(chr(memory[pointer]), end='')
        elif command == ',':
            memory[pointer] = ord(sys.stdin.read(1))
        elif command == '[':
            if memory[pointer] == 0:
                code_pointer = loop_map[code_pointer]
        elif command == ']':
            if memory[pointer] != 0:
                code_pointer = loop_map[code_pointer]

        code_pointer += 1

    end_time = time.time()
    execution_time = end_time - start_time
    print(f"\nTemps d'exécution : {execution_time:.6f} secondes.")

if __name__ == "__main__":
    if len(sys.argv) != 2:
        print("Usage: python brainfuck.py <chemin_du_fichier>")
        sys.exit(1)

    file_path = sys.argv[1]
    execute_brainfuck(file_path)
