import argparse
import csv
import io
import logging

def _setup_logger():
    pass

def _parse(infile):
    data = []
    keys = []
    with open(infile) as f:
        datablock = {}
        for line in f:
            if '[FRAME]' in line:
                datablock = {}
            if '=' in line:
                kv = line.split('=')
                key = kv[0]
                value = kv[1].strip()
                datablock[key] = value

                if key not in keys:
                    keys.append(key)
            if '[/FRAME]' in line:
                data.append(datablock)
    return {'values':data, 'keys':keys}

def _convert(data):
    if data['values'] and data['keys']:
        output = io.StringIO()
        writer = csv.DictWriter(output, fieldnames=data['keys'])
        writer.writeheader()
        writer.writerows(data['values'])
        return output.getvalue()
    
    return None

def _save(text, infile):
    outfn = infile + '.csv'
    outfh = open(outfn, 'w')
    outfh.write('sep=,\n')

    lines = text.split('\n')
    non_empty_lines = [line for line in lines if line.strip() != ""]
    for line in non_empty_lines:
        outfh.write(line.strip() + '\n')
    outfh.close()

def start():
    parser = argparse.ArgumentParser(description='Data sender for m143_sensor example')
    parser.add_argument('infile', default=None, help='input file')
    args = parser.parse_args()  
    parsed_data = _parse(args.infile)
    csv_data = _convert(parsed_data)
    _save(csv_data, args.infile)

if __name__ == "__main__":
	start()
