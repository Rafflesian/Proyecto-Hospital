import { ComponentFixture, TestBed } from '@angular/core/testing';

import { PersonasTable } from './personas-table';

describe('PersonasTable', () => {
  let component: PersonasTable;
  let fixture: ComponentFixture<PersonasTable>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      imports: [PersonasTable],
    }).compileComponents();

    fixture = TestBed.createComponent(PersonasTable);
    component = fixture.componentInstance;
    await fixture.whenStable();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
