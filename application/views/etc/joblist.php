<?php

switch($class_id) {
    // Novice | 1st Class
    case 0: $class_name = 'Novice'; break;
    case 1: $class_name = 'Swordman'; break;
    case 2: $class_name = 'Magician'; break;
    case 3: $class_name = 'Archer'; break;
    case 4: $class_name = 'Acolyte'; break;
    case 5: $class_name = 'Merchant'; break;
    case 6: $class_name = 'Thief'; break;
    // 2nd Class
    case 7: $class_name = 'Knight'; break;
    case 8: $class_name = 'Priest'; break;
    case 9: $class_name = 'Wizard'; break;
    case 10: $class_name = 'Blacksmith'; break;
    case 11: $class_name = 'Hunter'; break;
    case 12: $class_name = 'Assassin'; break;
    case 14: $class_name = 'Crusader'; break;
    case 15: $class_name = 'Monk'; break;
    case 16: $class_name = 'Sage'; break;
    case 17: $class_name = 'Rogue'; break;
    case 18: $class_name = 'Alchemist'; break;
    case 19: $class_name = 'Bard'; break;
    case 20: $class_name = 'Dancer'; break;
    // Rebirth Class
    case 4001: $class_name = 'Novice High'; break;
    case 4002: $class_name = 'Swordman High'; break;
    case 4003: $class_name = 'Magician High'; break;
    case 4004: $class_name = 'Archer High'; break;
    case 4005: $class_name = 'Acolyte High'; break;
    case 4006: $class_name = 'Merchant High'; break;
    case 4007: $class_name = 'Thief High'; break;
    // Trans 2nd Class
    case 4008: $class_name = 'Lord Knight'; break;
    case 4009: $class_name = 'High Priest'; break;
    case 4010: $class_name = 'High Wizard'; break;
    case 4011: $class_name = 'Whitesmith'; break;
    case 4012: $class_name = 'Sniper'; break;
    case 4013: $class_name = 'Assassin Cross'; break;
    case 4015: $class_name = 'Paladin'; break;
    case 4016: $class_name = 'Champion'; break;
    case 4017: $class_name = 'Professor'; break;
    case 4018: $class_name = 'Stalker'; break;
    case 4019: $class_name = 'Creator'; break;
    case 4020: $class_name = 'Clown'; break;
    case 4021: $class_name = 'Gypsy'; break;
    // 3rd Class
    case 4054: $class_name = 'Rune Knight'; break;
    case 4055: $class_name = 'Warlock'; break;
    case 4056: $class_name = 'Ranger'; break;
    case 4057: $class_name = 'Arch Bishop'; break;
    case 4058: $class_name = 'Mechanic'; break;
    case 4059: $class_name = 'Guillotine Cross'; break;
    case 4066: $class_name = 'Royal Guard'; break;
    case 4067: $class_name = 'Sorcerer'; break;
    case 4068: $class_name = 'Minstrel'; break;
    case 4069: $class_name = 'Wanderer'; break;
    case 4070: $class_name = 'Sura'; break;
    case 4071: $class_name = 'Genetic'; break;
    case 4072: $class_name = 'Shadow Chaser'; break;
    // Trans 3rd Class
    case 4060: $class_name = 'Rune Knight (Trans)'; break;
    case 4061: $class_name = 'Warlock (Trans)'; break;
    case 4062: $class_name = 'Ranger (Trans)'; break;
    case 4063: $class_name = 'Arch Bishop (Trans)'; break;
    case 4064: $class_name = 'Mechanic (Trans)'; break;
    case 4065: $class_name = 'Guillotine Cross (Trans)'; break;
    case 4073: $class_name = 'Royal Guard (Trans)'; break;
    case 4074: $class_name = 'Sorcerer (Trans)'; break;
    case 4075: $class_name = 'Minstrel (Trans)'; break;
    case 4076: $class_name = 'Wanderer (Trans)'; break;
    case 4077: $class_name = 'Sura (Trans)'; break;
    case 4078: $class_name = 'Genetic (Trans)'; break;
    case 4079: $class_name = 'Shadow Chaser (Trans)'; break;
    // Special Classes
    case 23: $class_name = 'Super Novice'; break;
    case 24: $class_name = 'Gunslinger'; break;
    case 25: $class_name = 'Ninja'; break;
    case 4045: $class_name = 'Super Baby'; break;
    case 4046: $class_name = 'Taekwon'; break;
    case 4047: $class_name = 'Star Gladiator'; break;
    case 4049: $class_name = 'Soul Linker'; break;
    case 4050: $class_name = 'Gangsi'; break;
    case 4051: $class_name = 'Death Knight'; break;
    case 4052: $class_name = 'Dark Collector'; break;
    case 4190: $class_name = 'Ex. Super Novice'; break;
    case 4191: $class_name = 'Ex. Super Baby'; break;
    case 4211: $class_name = 'Kagerou'; break;
    case 4212: $class_name = 'Oboro'; break;
    case 4215: $class_name = 'Rebellion'; break;
    // Baby Novice | Baby 1st Class
    case 4023: $class_name = 'Baby Novice'; break;
    case 4024: $class_name = 'Baby Swordman'; break;
    case 4025: $class_name = 'Baby Magician'; break;
    case 4026: $class_name = 'Baby Archer'; break;
    case 4027: $class_name = 'Baby Acolyte'; break;
    case 4028: $class_name = 'Baby Merchant'; break;
    case 4029: $class_name = 'Baby Thief'; break;
    // Baby 2nd Class
    case 4030: $class_name = 'Baby Knight'; break;
    case 4031: $class_name = 'Baby Priest'; break;
    case 4032: $class_name = 'Baby Wizard'; break;
    case 4033: $class_name = 'Baby Blacksmith'; break;
    case 4034: $class_name = 'Baby Hunter'; break;
    case 4035: $class_name = 'Baby Assassin'; break;
    case 4037: $class_name = 'Baby Crusader'; break;
    case 4038: $class_name = 'Baby Monk'; break;
    case 4039: $class_name = 'Baby Sage'; break;
    case 4040: $class_name = 'Baby Rogue'; break;
    case 4041: $class_name = 'Baby Alchemist'; break;
    case 4042: $class_name = 'Baby Bard'; break;
    case 4043: $class_name = 'Baby Dancer'; break;
    // Baby 3rd Class
    case 4096: $class_name = 'Baby Rune Knight'; break;
    case 4097: $class_name = 'Baby Warlock'; break;
    case 4098: $class_name = 'Baby Ranger'; break;
    case 4099: $class_name = 'Baby Arch Bishop'; break;
    case 4100: $class_name = 'Baby Mechanic'; break;
    case 4101: $class_name = 'Baby Guillotine Cross'; break;
    case 4102: $class_name = 'Baby Royal Guard'; break;
    case 4103: $class_name = 'Baby Sorcerer'; break;
    case 4104: $class_name = 'Baby Minstrel'; break;
    case 4105: $class_name = 'Baby Wanderer'; break;
    case 4106: $class_name = 'Baby Sura'; break;
    case 4107: $class_name = 'Baby Genetic'; break;
    case 4108: $class_name = 'Baby Shadow Chaser'; break;
    // Event Class
    case 22: $class_name = 'Wedding'; break;
    case 26: $class_name = 'Christmas'; break;
    case 27: $class_name = 'Summer'; break;
    case 28: $class_name = 'Hanbok'; break;
    case 4048: $class_name = 'Star Gladiator (Union)'; break;
    default: 'Unknown';
}
  
?>